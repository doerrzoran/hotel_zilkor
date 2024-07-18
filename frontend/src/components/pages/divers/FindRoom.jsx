import { useState } from "react";
import { useGetHostelsQuery, usePostFindRoomMutation } from "../../../slices/ApiSlice";

export default function FindRoom() {
    const [arrivalDate, setArrivalDate] = useState()
    const [depatureDate, setDepatureDate] = useState()
    const [hostel, setHostel] = useState()
    const [numberOfGuest, setNumberOfGuest] = useState()
    const [numberOfBed, setNumberOfBed] = useState()
    const[findRoom, {isLoading, error, isSuccess}] = usePostFindRoomMutation()
    const { data } = useGetHostelsQuery()


    const handleSubmit = async (event) => {
        event.preventDefault()
        const requestData = {
            hostel: hostel,
            arrivalDate: arrivalDate,
            depatureDate: depatureDate,
        };
        await findRoom(requestData);
    }

    return(
        <>
            {
                isSuccess ? <div></div>:
                <form onSubmit={handleSubmit}>
                    <label htmlFor="hostel">choisisser une destination</label>
                    <select name="hostel">
                        {data.map(hotel => (
                            <option key={hotel.id} value={hotel.id}>
                                {hotel.city}
                            </option>
                        ))}
                    </select>
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
                    <label htmlFor="numberOfGuest">départ</label>
                    <input 
                        type="number" 
                        name="numberOfGuest" 
                        id="numberOfGuest"
                        min="1"
                        max="4"
                        value={numberOfGuest}
                        onChange={(event) => setNumberOfGuest(event.target.value)}
                        />
                    <label htmlFor="numberOfBed">départ</label>
                    <input 
                        type="number" 
                        name="numberOfBed" 
                        id="numberOfBed"
                        min="1"
                        max="4"
                        value={numberOfBed}
                        onChange={(event) => setNumberOfBed(event.target.value)}
                        />
                    
                    
                    <button type="submit">Reserver</button>
                </form>
            }
        </>
    )
}
