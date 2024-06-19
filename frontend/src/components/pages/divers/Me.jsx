import { useEffect } from "react"
import { useGetMeQuery } from "../../../slices/ApiSlice"

export default function Me() {
    const { data, error, isLoading, refetch } = useGetMeQuery()

    useEffect(() => {
        // Refetch the query whenever the component mounts or the token changes
        refetch()
    }, [])

    if (isLoading) return <div>Loading...</div>
    if (error) return <div>Error: {error.message}</div>

    return (
        <div>
            <h1>My Info</h1>
            <p>Username: {data.username}</p>
        </div>
    )
}
