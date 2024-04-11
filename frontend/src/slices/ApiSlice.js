
import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react"

export const ApiSlice = createApi({
    baseQuery: fetchBaseQuery({ baseUrl: ''}),
    endpoints: (builder) =>({
        getHome : builder.query({
            query : () => ({
                url: '',
            })
        }),
    })
})