import { useEffect, useState } from "react";
import { useGetRoomsQuery, usePostBookingMutation } from "../../../slices/ApiSlice";
import { useNavigate } from 'react-router-dom';

export default function Booking(props) {
    const navigate = useNavigate()
    const [room, setRoom] = useState(301);
    const [book, { isLoading, error, isSuccess }] = usePostBookingMutation();
    const { rooms, arrivalDate, departureDate } = props;
    const [currentPage, setCurrentPage] = useState(1);
    const roomsPerPage = 3;
    

    const handleSubmit = async (event) => {
        event.preventDefault();
        const requestData = {
            room: room,
            arrivalDate: arrivalDate,
            departureDate: departureDate,
        };
        try {
            const response = await book(requestData).unwrap();
            // Gérer le succès ici
            console.log("Réservation réussie :", response);
        } catch (err) {
            // Gérer l'erreur ici
            if (err.status === 401 && err.data?.message === "JWT Token not found") {
                navigate('login')
            } else {
                console.error("Erreur lors de la réservation :", err);
            }
        }
    };

    useEffect(() => {
        console.log(rooms);
    }, [rooms]);

    // Calculer les index des chambres à afficher
    const indexOfLastRoom = currentPage * roomsPerPage;
    const indexOfFirstRoom = indexOfLastRoom - roomsPerPage;
    const currentRooms = rooms ? rooms.slice(indexOfFirstRoom, indexOfLastRoom) : [];

    // Changer de page
    const paginate = (pageNumber) => setCurrentPage(pageNumber);

    return (
        <>
            {rooms ? (
                <form onSubmit={handleSubmit}>
                    {currentRooms.map((room) => (
                        <div className="roomCard" key={room.roomNumber}>
                            {/* {room.roomNumber} */}
                            <img 
                            src={`/images/${room.image}`} 
                            alt={room.image} 
                            onError={(e) => {
                                console.error("Error loading image:", e.target.src);
    
                              }}
                            />
                            <button onClick={() => setRoom(room.roomNumber)}>
                                Réserver
                            </button>
                        </div>
                    ))}
                    
                    {/* Pagination */}
                    <div>
                        {Array.from({ length: Math.ceil(rooms.length / roomsPerPage) }, (_, i) => (
                            <button key={i} onClick={() => paginate(i + 1)}>
                                {i + 1}
                            </button>
                        ))}
                    </div>

                    {/* Ajoutez ici les champs pour arrivalDate, departureDate, et le bouton de soumission */}
                </form>
            ) : (
                <div>Aucune chambre disponible</div>
            )}
        </>
    );
}
