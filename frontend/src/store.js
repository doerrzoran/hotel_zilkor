import { configureStore } from '@reduxjs/toolkit';
import { ApiSlice } from "./slices/ApiSlice.js";

export default configureStore({
    reducer: {
        'Api' : ApiSlice.reducer,
    },
    middleware: (getDefaultMiddleware) => {
        return getDefaultMiddleware().concat(ApiSlice.middleware)
    }
})