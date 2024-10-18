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
        getMyBookings: builder.query({
            query: () => ({
                url: '/api/guest/bookings',
            })
        }),
        getRooms: builder.query({
            query: () => ({
                url: 'api/backoffice/rooms',
            })
        }),
        getHostelsList: builder.query({
            query: () => ({
                url: '/api/backoffice/hostels/list',
            })
        }),
        getBookings: builder.query({
            query: () => ({
                url: '/api/backoffice/booking/list',
            })
        }),
        getGuests: builder.query({
            query: () => ({
                url: '/api/backoffice/guests',
            })
        }),
        postAddHostel: builder.mutation({
            query: (body) => ({
                url: '/api/backoffice/add/hostel',
                method: 'POST',
                body,
            })
        }),
        getHostels: builder.query({
            query: () => ({
                url: '/hostels',
            })
        }),
        getHostelDetail: builder.query({
            query: () => ({
                url: '/hostel/detail',
            })
        }),
        getRoomAviability: builder.query({
            query: (id) => ({
                url: `room/aviability/${id}`,
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
        deleteBooking: builder.mutation({
            query: (body) => ({
                url: '/api/delete/booking',
                method: 'DELETE',
                body,
            })
        }),
        postFindRoom: builder.mutation({
            query: (body) => ({
                url: '/room/selection',
                method: 'POST',
                body,
            })
        }),
    })
})

// Export hooks for usage in functional components, which are auto-generated based on the defined endpoints
export const {
    useGetRoomsQuery,
    useGetHostelsQuery,
    useGetHostelsListQuery,
    useGetBookingsQuery,
    useGetMeQuery,
    useGetMyBookingsQuery,
    usePostRegisterMutation,
    usePostLoginMutation,
    usePostBookingMutation,
    usePostFindRoomMutation,
    useDeleteBookingMutation,
    useGetGuestsQuery,
    useGetHostelDetailQuery,
    usePostAddHostelMutation
} = ApiSlice;
