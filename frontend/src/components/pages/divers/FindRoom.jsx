import { useEffect, useState } from "react";
import { useGetHostelsQuery, usePostFindRoomMutation } from "../../../slices/ApiSlice";
import Booking from "./Booking";

export default function FindRoom() {
    const [arrivalDate, setArrivalDate] = useState()
    const [departureDate, setDepartureDate] = useState()
    const [hostel, setHostel] = useState(1)
    const [numberOfGuest, setNumberOfGuest] = useState(1)
    const [numberOfBeds, setNumberOfBeds] = useState(1)
    const[findRoom, { isLoading, isSuccess}] = usePostFindRoomMutation()
    const { data } = useGetHostelsQuery()
    const [response, setResponse] = useState(null);
    const [error, setError] = useState(null);

    const getTomorrowDate = () => {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        return tomorrow.toISOString().split('T')[0]; // Format YYYY-MM-DD
    }

    const getDayAfterArrivalDate = () => {
        if (!arrivalDate) return getTomorrowDate();
        const arrival = new Date(arrivalDate);
        const dayAfterArrival = new Date(arrival);
        dayAfterArrival.setDate(dayAfterArrival.getDate() + 1);
        return dayAfterArrival.toISOString().split('T')[0]; // Format YYYY-MM-DD
    }

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
                    <label htmlFor="hostel">choisir une destination</label>
                    <select name="hostel" onChange={(event) => setHostel(event.target.value)}>
                        {data && data.map(hostel => (
                            <option key={hostel.id} value={hostel.id} >
                                {hostel.city}
                            </option>
                        ))}
                    </select>
                    <label htmlFor="arrivalDate">arrivée</label>
                    <input 
                        type="date" 
                        name="arrivalDate" 
                        id="arrivalDate"
                        min={getTomorrowDate()}
                        value={arrivalDate}
                        onChange={(event) => setArrivalDate(event.target.value)}
                        />
                    <label htmlFor="departureDate">départ</label>
                    <input 
                        type="date" 
                        name="departureDate" 
                        id="departureDate"
                        min={getDayAfterArrivalDate()}
                        value={departureDate}
                        onChange={(event) => setDepartureDate(event.target.value)}
                        />
                   <label htmlFor="numberOfGuest">Nombre de personnes</label>
                        <select 
                            name="numberOfGuest" 
                            id="numberOfGuest"
                            value={numberOfGuest}
                            onChange={(event) => setNumberOfGuest(event.target.value)}
                            >
                            {[1, 2, 3, 4].map((value) => (
                                <option key={value} value={value}>
                                    {value}
                                </option>
                            ))}
                        </select>

                    <label htmlFor="numberOfBeds">Nombre de lits</label>
                        <select 
                            name="numberOfBeds" 
                            id="numberOfBeds"
                            value={numberOfBeds}
                            onChange={(event) => setNumberOfBeds(event.target.value)}
                            >
                            {[1, 2, 3, 4].map((value) => (
                                <option key={value} value={value}>
                                    {value}
                                </option>
                            ))}
                        </select>
                                    
                    
                    <button type="submit">trouver une chambre</button>
                </form>
            }
        </>
    )
}
