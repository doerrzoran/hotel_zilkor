import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react"

// Create a base query function with the ability to include headers
const baseQuery = fetchBaseQuery({
    baseUrl: 'https://127.0.0.1:8000',
    prepareHeaders: (headers) => {
        const token = localStorage.getItem('jwtToken'); // Get the token from local storage
        if (token) {
            headers.set('Authorization', `Bearer ${token}`);
        }
        return headers;
    }
});

const baseQueryWithReauth = async (args, api, extraOptions) => {
    let result = await baseQuery(args, api, extraOptions)
    if (result.error && result.error.status === 401) {
        // Remove the token from localStorage
        localStorage.removeItem('jwtToken')
    }
    return result
}

export const ApiSlice = createApi({
    reducerPath: 'Api',
    baseQuery: baseQueryWithReauth,
    endpoints: (builder) => ({
        getMe: builder.query({
            query: () => ({
                url: '/api/me',
            })
        }),
        getRooms: builder.query({
            query: () => ({
                url: 'api/backoffice/rooms',
            })
        }),
        postRegister: builder.mutation({
            query: (body) => ({
                url: 'api/register',
                method: 'POST',
                body,
            })
        }),
        postLogin: builder.mutation({
            query: (body) => ({
                url: '/api/login_check',
                method: 'POST',
                body,
            })
        }),
        postBooking: builder.mutation({
            query: (body) => ({
                url: '/api/booking',
                method: 'POST',
                body,
            })
        }),
    })
})

// Export hooks for usage in functional components, which are auto-generated based on the defined endpoints
export const {
    useGetRoomsQuery,
    useGetMeQuery,
    usePostRegisterMutation,
    usePostLoginMutation,
    usePostBookingMutation
} = ApiSlice;
