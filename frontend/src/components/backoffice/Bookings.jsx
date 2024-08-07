import { useEffect } from "react";
import { useGetBookingsQuery } from "../../slices/ApiSlice";

export default function Bookings() {
    const {data, isLoading, error } = useGetBookingsQuery()

    useEffect(() => {
        console.log('isLoading:', isLoading);
        console.log('error:', error);
        console.log('data:', data);
    }, [data, isLoading, error]);

    return(
        <>
            {isLoading ? (
                <p>En Charge</p>
            ) : (
                <div className="bookings-container">
                    <h1>liste de reservations</h1>
                    {data && data.map(booking => (
                        <div key={booking.id} className="room-card">
                            <h3> {booking.id}</h3>
                            <p>guest: {booking.guest.slug}</p>
                            <p>hotel: {booking.room.hostel.city}</p>
                            <p>chambre: {booking.room.roomNumber}</p>
                            <p>durée: {booking.arrivalDate}</p>
                            <p>date arrivé: {booking.arrivalDate}</p>
                            <p>date de départ: {booking.depatureDate}</p>
                            <p>Statut: {booking.isActive ? 'annulé' : 'en cours'}</p>
                            <button >detail</button>
                        </div>
                    ))}
                </div>
            )}
        </>
    )
    
};
