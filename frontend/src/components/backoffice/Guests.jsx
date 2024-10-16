import { useEffect } from "react";
import { useGetGuestsQuery } from "../../slices/ApiSlice";

export default function Guests() {
    const {data, error, isloading} = useGetGuestsQuery()

    // useEffect(() => {
    //     console.log(data)
    // }, [data])

    return(
        <>
        {
            isloading ? <p>loading</p>:
        <div className="booking-container">

            {
                data && data.map(guest =>(
                    <li className="booking-card" key={guest.id}>
                        <ul>{guest.slug} </ul>
                        <ul>{guest.email} </ul>        
                        <ul>{guest.createdAt} </ul>        
                        <ul>{guest.updatedAt} </ul>        
                    </li>
                ))
            }
        </div>
            }
        </>
    )
}
