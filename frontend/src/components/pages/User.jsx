import { useEffect, useState } from "react";
import { useGetMyBookingsQuery, useDeleteBookingMutation } from "../../slices/ApiSlice";

export default function User() {
    const {data, isLoading} = useGetMyBookingsQuery()
    const [roomDetail, setRoomDetail] = useState()
    const [deleteBooking, { isSuccess, isError }] = useDeleteBookingMutation();
    const handleDelete = async (bookingId) => {
        try {
            await deleteBooking({ id: bookingId }).unwrap();  // This will resolve or throw based on success/failure
        } catch (err) {
            console.error('Erreur lors de l\'annulation de la réservation :', err);
            alert('Une erreur est survenue lors de l\'annulation de la réservation.');
        }
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    };
    
    // React to changes in `isSuccess` or `isError` outside of the async function
    useEffect(() => {
        console.log(data)
        if (isSuccess) {
            console.log("La réservation a été annulée avec succès.");
            location.reload()
        }
        
        if (isError) {
            console.log('Une erreur est survenue lors de l\'annulation de la réservation.');
        }
    }, [isSuccess, isError, data]);
    return (
        <>
            {
                roomDetail ? (
                    <div className="room-details">
                        <h2>Détails de la chambre</h2>
                        <img
                                    src={`/images/${roomDetail.image}`}
                                    alt={roomDetail.image}
                                    onError={(e) => {
                                        console.error("Error loading image:", e.target.src);
                                    }}
                                />
                        <p>{roomDetail.hostel.city}</p>
                        <p> {roomDetail.description}</p>
                        <p> {roomDetail.price} €</p>
                        <button onClick={() => setRoomDetail(null)}>Retour à la liste</button> {/* Back button */}
                    </div>
                ) : isLoading ? (  // Correct conditional for loading
                    <p>En Charge</p>
                ) : (
                    <div className="booking-container">
                        <h1 className="title">Liste de réservations</h1>
                        {data && data.map((booking) => (
                            <div key={booking.id} className="booking-card">
                                <p>Destination: {booking.room.hostel.city}</p>
                                <p>Date d'arrivée: {formatDate(booking.arrivalDate)}</p>
                                <p>Date de départ: {formatDate(booking.departureDate)}</p>
                                <div>
                                    <button className="cancelButton" onClick={() => handleDelete(booking.id)}>Annuler</button>
                                    <button onClick={() => setRoomDetail(booking.room)}>Détail</button> {/* Pass booking.room */}
                                </div>
                            </div>
                        ))}
                    </div>
                )
            }
        </>
    );
}  