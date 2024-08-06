import { useEffect, useState } from "react";
import { useGetHostelsQuery, usePostFindRoomMutation } from "../../../slices/ApiSlice";
import Booking from "./Booking";

export default function FindRoom() {
    const [arrivalDate, setArrivalDate] = useState()
    const [departureDate, setDepartureDate] = useState()
    const [hostel, setHostel] = useState(1)
    const [numberOfGuest, setNumberOfGuest] = useState()
    const [numberOfBeds, setNumberOfBeds] = useState()
    const[findRoom, { isLoading, isSuccess}] = usePostFindRoomMutation()
    const { data } = useGetHostelsQuery()
    const [response, setResponse] = useState(null);
    const [error, setError] = useState(null);

    // useEffect(() => {
    //     console.log(response)
    // }, [response])


    const handleSubmit = async (event) => {
        event.preventDefault()
        const requestData = {
            hostel: hostel,
            arrivalDate: arrivalDate,
            departureDate: departureDate,
            numberOfGuest: numberOfGuest,
            numberOfBeds: numberOfBeds,
            
        };
        try {
            const response = await findRoom(requestData).unwrap();
            setResponse(response);
            setError(null); // Clear any previous errors
        } catch (err) {
            setError('Failed to book room');
            setResponse(null); // Clear any previous response
        }
    }

    return(
        <>
            {
                isSuccess ? <Booking rooms = {response} 
                                    arrivalDate = {arrivalDate} 
                                    departureDate = {departureDate} 
                            />:
                <form onSubmit={handleSubmit}>
                    <label htmlFor="hostel">choisisser une destination</label>
                    <select name="hostel" onChange={(event) => setHostel(event.target.value)}>
                        {data && data.map(hostel => (
                            <option key={hostel.id} value={hostel.id} >
                                {hostel.city}
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
                    <label htmlFor="departureDate">départ</label>
                    <input 
                        type="date" 
                        name="departureDate" 
                        id="departureDate"
                        value={departureDate}
                        onChange={(event) => setDepartureDate(event.target.value)}
                        />
                    <label htmlFor="numberOfGuest">nombre de personnes</label>
                    <input 
                        type="number" 
                        name="numberOfGuest" 
                        id="numberOfGuest"
                        min="1"
                        max="4"
                        value={numberOfGuest}
                        onChange={(event) => setNumberOfGuest(event.target.value)}
                        />
                    <label htmlFor="numberOfBeds">nombre de lits</label>
                    <input 
                        type="number" 
                        name="numberOfBeds" 
                        id="numberOfBeds"
                        min="1"
                        max="4"
                        value={numberOfBeds}
                        onChange={(event) => setNumberOfBeds(event.target.value)}
                        />
                    
                    
                    <button type="submit">trouver une chambre</button>
                </form>
            }
        </>
    )
}
