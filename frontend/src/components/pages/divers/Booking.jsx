import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { usePostBookingMutation } from "../../../slices/ApiSlice";

export default function Booking(props) {
    const navigate = useNavigate();
    const [room, setRoom] = useState(null); // Room selected for booking
    const [selectedRoom, setSelectedRoom] = useState(null); // Room selected for confirmation
    const [book, { isLoading, error, isSuccess }] = usePostBookingMutation();
    const { rooms, arrivalDate, departureDate } = props;
    const [currentPage, setCurrentPage] = useState(1);
    const [bookingSuccess, setbookingSuccess] = useState('');
    const roomsPerPage = 3;

    // Maximum number of pages to show
    const maxPages = 10;

    const handleSubmit = async (event) => {
        event.preventDefault();
        const requestData = {
            room: selectedRoom.id, // Use room.id for the booking request
            arrivalDate: arrivalDate,
            departureDate: departureDate,
        };
        try {
            const response = await book(requestData).unwrap();
            setbookingSuccess("Votre réservation a bien été enregistrée !");
            setSelectedRoom(null); // Reset selected room after booking
            // navigate('my/booking')
        } catch (err) {
            if (err.status === 401 && err.data?.message === "JWT Token not found") {
                alert("Veuillez vous connecter ou créer un compte pour réserver cette chambre");
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

    // Handle room selection for confirmation
    const handleReserveClick = (room) => {
        setSelectedRoom(room); // Set the selected room for confirmation
    };

    // Handle cancellation of reservation
    const handleCancel = () => {
        setSelectedRoom(null); // Reset the selected room
    };

    return (
        <>
            {rooms ? (
                <div>
                    {bookingSuccess && <p className="success-message">{bookingSuccess}</p>}

                    {/* If a room is selected, show the confirmation section */}
                    {selectedRoom ? (
                        <div className="room-details">
                            <h3>Confirmer la réservation</h3>
                            <img
                                src={`/images/${selectedRoom.image}`}
                                alt={selectedRoom.image}
                                onError={(e) => {
                                    console.error("Error loading image:", e.target.src);
                                }}
                            />
                            <p>Vous avez choisi la chambre {selectedRoom.roomNumber} au prix de {selectedRoom.price} €.</p>
                            <p>Arrivée : {arrivalDate}</p>
                            <p>Départ : {departureDate}</p>
                            <button className="confirmButton" onClick={handleSubmit}>
                                Confirmer
                            </button>
                            <button className="cancelButton" onClick={handleCancel}>
                                Annuler
                            </button>
                        </div>
                    ) : (
                        <form>
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
                                            <button
                                                className="reserveButton"
                                                type="button"
                                                onClick={() => handleReserveClick(room)}
                                            >
                                                Réserver
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </form>
                    )}

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
                </div>
            ) : (
                <div>Aucune chambre disponible</div>
            )}
        </>
    );
}
