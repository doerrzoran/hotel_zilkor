import { useState } from "react";
import { useGetRoomsQuery, usePostBookingMutation } from "../../../slices/ApiSlice";

export default function Booking() {
    const [arrivalDate, setArrivalDate] = useState()
    const [depatureDate, setDepatureDate] = useState()
    const [room, setRoom] = useState(301)
    const [book, { isLoading, error, isSuccess }] = usePostBookingMutation()
    // const { data } = useGetRoomsQuery()
    const handleSubmit = async (event) => {
        event.preventDefault()
        const requestData = {
            room: room,
            arrivalDate: arrivalDate,
            depatureDate: depatureDate,
        };
        await book(requestData);
    }

    return(
        <>
            {
                isSuccess ? <div></div>:
                <form onSubmit={handleSubmit}>
                    <label htmlFor="arrivalDate">arrivé</label>
                    <input 
                        type="date" 
                        name="arrivalDate" 
                        id="arrivalDate"
                        value={arrivalDate}
                        onChange={(event) => setArrivalDate(event.target.value)}
                        />
                    <label htmlFor="depatureDate">départ</label>
                    <input 
                        type="date" 
                        name="depatureDate" 
                        id="depatureDate"
                        value={depatureDate}
                        onChange={(event) => setDepatureDate(event.target.value)}
                        />
                    <button type="submit">Reserver</button>
                </form>
            }
        </>
    )
    
}
