import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { usePostBookingMutation } from "../../../slices/ApiSlice";

export default function Booking(props) {
    const navigate = useNavigate();
    const [room, setRoom] = useState(301);
    const [book, { isLoading, error, isSuccess }] = usePostBookingMutation();
    const { rooms, arrivalDate, departureDate } = props;
    const [currentPage, setCurrentPage] = useState(1);
    const roomsPerPage = 3;
    
    // Maximum number of pages to show
    const maxPages = 10;

    const handleSubmit = async (event) => {
        event.preventDefault();
        const requestData = {
            room: room,
            arrivalDate: arrivalDate,
            departureDate: departureDate,
        };
        try {
            const response = await book(requestData).unwrap();
            alert("votre reservation est un success !");
            navigate('my/booking')
        } catch (err) {
            if (err.status === 401 && err.data?.message === "JWT Token not found") {
                alert("veuillez vous connecter ou creer un compte pour reserver cette chambre");
                navigate('login');
            } else {
                console.error("Erreur lors de la réservation :", err);
            }
        }
    };

    useEffect(() => {
        console.log(rooms);
    }, [rooms]);

    // Calculate indexes for current page's rooms
    const indexOfLastRoom = currentPage * roomsPerPage;
    const indexOfFirstRoom = indexOfLastRoom - roomsPerPage;
    const currentRooms = rooms ? rooms.slice(indexOfFirstRoom, indexOfLastRoom) : [];

    // Calculate total pages
    const totalPages = Math.ceil(rooms.length / roomsPerPage);
    
    // Handle page change
    const paginate = (pageNumber) => setCurrentPage(pageNumber);

    return (
        <>
            {rooms ? (
                <form onSubmit={handleSubmit}>
                    <div className="roomsContainer">
                        {currentRooms.map((room) => (
                            <div className="roomCard" key={room.roomNumber}>
                                <img
                                    src={`/images/${room.image}`}
                                    alt={room.image}
                                    onError={(e) => {
                                        console.error("Error loading image:", e.target.src);
                                    }}
                                />
                                <div className="roomInfo">
                                    <p className="roomDescription">{room.description}</p>
                                    <p className="roomPrice">{room.price} €</p>
                                    <button className="reserveButton" onClick={() => setRoom(room.roomNumber)}>
                                        Réserver
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Pagination */}
                    <div className="pagination">
                        {/* "Previous" Button */}
                        {currentPage > 1 && (
                            <button className="paginationButton" onClick={() => paginate(currentPage - 1)}>
                                Précédent
                            </button>
                        )}

                        {/* Page Numbers */}
                        {Array.from(
                            { length: Math.min(maxPages, totalPages) },
                            (_, i) => i + 1
                        ).map((pageNumber) => (
                            <button
                                key={pageNumber}
                                onClick={() => paginate(pageNumber)}
                                className={`paginationButton ${pageNumber === currentPage ? 'active' : ''}`}
                            >
                                {pageNumber}
                            </button>
                        ))}

                        {/* "Next" Button */}
                        {currentPage < totalPages && (
                            <button className="paginationButton" onClick={() => paginate(currentPage + 1)}>
                                Suivant
                            </button>
                        )}
                    </div>

                    {/* Add fields for arrivalDate, departureDate, and submission button */}
                </form>
            ) : (
                <div>Aucune chambre disponible</div>
            )}
        </>
    );
}
