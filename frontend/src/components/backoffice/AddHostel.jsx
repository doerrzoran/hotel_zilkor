import { useState } from "react";
import { usePostAddHostelMutation } from "../../slices/ApiSlice";

export default function AddHostel() {
    const [addHostel, { isError, isSuccess }] = usePostAddHostelMutation();  
    const [city, setCity] = useState("");
    const [country, setCountry] = useState("");
    const [description, setDescription] = useState("");
    const [location, setLocation] = useState("");

    const handleSubmit = async (e) => {
        e.preventDefault();
        const requestData = {
            city,
            country,
            location,
            description
        };

        // Trigger the mutation function to make the API request
        await addHostel(requestData);
    };

    return (
        <>
        <article className='formContainer'>

        {isSuccess && <p>Hostel added successfully!</p>}
        {isError && <p>Error adding hostel.</p>}
            <form onSubmit={handleSubmit}>
                <div>
                    <label>
                        ville:
                        <input 
                            type="text" 
                            id="city" 
                            value={city} 
                            required 
                            onChange={(e) => setCity(e.target.value)} 
                        />
                    </label>
                </div>
                <div>
                    <label>
                        pays:
                        <input 
                            type="text" 
                            id="country" 
                            value={country} 
                            required 
                            onChange={(e) => setCountry(e.target.value)} 
                        />
                    </label>
                </div>
                <div>
                    <label>
                        location:
                        <input 
                            type="text" 
                            id="location" 
                            value={location} 
                            required 
                            onChange={(e) => setLocation(e.target.value)} 
                        />
                    </label>
                </div>
                <div>
                    <label>
                        Description:
                        <input 
                            type="text" 
                            id="description" 
                            value={description} 
                            required 
                            onChange={(e) => setDescription(e.target.value)} 
                        />
                    </label>
                </div>
                <div>
                    <button type="submit">Enregistrer</button>
                </div>
            </form>
        </article>
            
            
        </>
    );
}