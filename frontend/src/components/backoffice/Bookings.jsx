import { useEffect } from "react";
import { useGetBookingsQuery } from "../../slices/ApiSlice";

export default function Bookings() {
    const {data, isLoading, error } = useGetBookingsQuery()
    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    };
    
    // useEffect(() => {
    //     console.log('isLoading:', isLoading);
    //     console.log('error:', error);
    //     console.log('data:', data);
    // }, [data, isLoading, error]);

    return(
        <>
            {isLoading ? (
                <p>En Charge</p>
            ) : (
                <div className="booking-container">
                    <h1>liste de reservations</h1>
                    {data && data.map(booking => (
                        <div key={booking.id} className="booking-card">
                            <p>guest: <a href="">{booking.guest.slug}</a></p>
                            <p>hotel: {booking.room.hostel.city}</p>
                            <p>chambre: {booking.room.roomNumber}</p>
                            <p>durée: </p>
                            <p>date arrivé: {formatDate(booking.arrivalDate)}</p>
                            <p>date de départ: {formatDate(booking.departureDate)}</p>
                            <p>Statut: {booking.isActive ? 'annulé' : 'en cours'}</p>
                            <button>detail</button>
                        </div>
                    ))}
                </div>
            )}
        </>
    )
    
};
