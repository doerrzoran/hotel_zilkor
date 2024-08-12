import { useEffect } from "react";
import { useGetMyBookingsQuery } from "../../slices/ApiSlice";

export default function User() {
    const {data, isLoading, error } = useGetMyBookingsQuery()

    useEffect(() => {
        console.log(data)
    }, [data])

    return(
        <>
            {isLoading ? (
                <p>En Charge</p>
            ) : (
                <div className="rooms-container">
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
                            <button >annuler</button>
                        </div>
                    ))}
                </div>
            )}
        </>
    )
}
