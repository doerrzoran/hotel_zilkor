import React, { useEffect } from "react";
import { useGetRoomsQuery } from "../../slices/ApiSlice";


export default function Rooms() {
    const { data, isLoading, error } = useGetRoomsQuery();
   


    return (
        <>
            {isLoading ? (
                <p>En Charge</p>
            ) : (
                <div className="hostels-container">
                    {data && data.map(hostel => (
                        <div key={hostel.hostel} className="hostel-section">
                            <h2> {hostel.hostel}</h2>
                            <div className="rooms-container">
                                {hostel.rooms.map(room => (
                                    <div key={room.id} className="room-card">
                                        <h3> {room.roomNumber}</h3>
                                        <p>Capacité: {room.capacity}</p>
                                        <p>Nombre de lits: {room.numberOfBed}</p>
                                        <p>Statu: {room.isAvailable ? 'libre' : 'occupé'}</p>
                                        <button >detail</button>
                                    </div>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </>
    );
}
