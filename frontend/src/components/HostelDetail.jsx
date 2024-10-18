import { useEffect } from "react";
import { useGetHostelDetailQuery } from "../slices/ApiSlice";

export default function HostelDetail(params) {
    const {data, isloading } = useGetHostelDetailQuery()

    useEffect(() => {
        console.log(data)
    })

    return(
        <>
            {
                isloading ? <p>en charge</p>:
                <div className="hostelContainer">
                    {
                        data && data.map(hostel =>(
                            <div key={hostel.city} className="hostelCard">
                                <img src={`/images/${hostel.image}`} alt={hostel.image} />
                                <p>{hostel.city} </p>
                                <p>{hostel.description} </p>
                            </div>
                        ))
                    }
                </div>
            }
        </>
    )
}
