
import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react"


export const ApiSlice = createApi({
    reducerPath: 'Api',
    baseQuery: fetchBaseQuery({ baseUrl: 'https://127.0.0.1:8000'}),
    endpoints: (builder) =>({
        getHome : builder.query({
            query : () => ({
                url: '',
            })
        }),
        getRooms : builder.query({
            query : () => ({
                url: '/rooms',
            })
        }),
        getRegister: builder.query({
            query : () => ({
                url: '/register',
            })
        }),
        postRegister: builder.mutation({
            query : (body) => ({
                url: '/register',
                method: 'POST',
                body,
            })
        }),
        getLogin: builder.query({
            query : () => ({
                url: '/login',
            })
        }),
    })
})

export const {
    useGetRoomsQuery,
    useGetRegisterQuery,
    usePostRegisterMutation,
    useGetLoginQuery
} = ApiSlice