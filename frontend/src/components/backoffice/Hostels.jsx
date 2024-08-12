import { useEffect, useState } from "react";
import { useGetHostelsListQuery } from "../../slices/ApiSlice";
import { useNavigate } from "react-router-dom";
import Backoffice from "./Backoffice";

export default function Hostels() {
    const { data, error, isLoading } = useGetHostelsListQuery();
    const [rooms, setRooms] = useState([]);
    const [selectedHostelId, setSelectedHostelId] = useState(null);
    const navigate = useNavigate();

    useEffect(() => {
        if (error && error.status === 403) {
            // Redirect to a "Not Authorized" page or login page
            navigate('/');
        }
    }, [error, navigate]);

    const displayRooms = (hostelId) => {
        const selectedHostel = data.find(hostel => hostel.id === hostelId);
        if (selectedHostel) {
            setRooms(selectedHostel.rooms);
            setSelectedHostelId(hostelId);
        }
    };

    if (isLoading) return <div>Loading...</div>;
    if (error) return <div>Erreur de chargement</div>;

    return (
        <div>
            <Backoffice/>
            {selectedHostelId ? (
                <div className="rooms-container">
                    {rooms.map(room => (
                        <div key={room.id} className="room-card">
                            <h3>{room.roomNumber}</h3>
                            <p>Capacité: {room.capacity}</p>
                            <p>Nombre de lits: {room.numberOfBed}</p>
                            <p>Status: {room.isAvailable ? 'occupé' : 'libre' }</p>
                            <button onClick={() => setSelectedHostelId(null)}>Back to Hostels</button>
                        </div>
                    ))}
                </div>
            ) : (
                data && data.map(hostel => (
                    <div key={hostel.id} className="room-card">
                        <h3>{hostel.slug}</h3>
                        <p>Ville: {hostel.city}</p>
                        <p>Nombre de chambres: {hostel.numberOfRooms}</p>
                        <p>Manager: {hostel.manager ? hostel.manager.slug : 'N/A'}</p>
                        <button onClick={() => displayRooms(hostel.id)}>Detail</button>
                    </div>
                ))
            )}
        </div>
    );
}
