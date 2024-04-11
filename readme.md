hotelZilkor

# Create a new Symfony project named "backend"
symfony new --webapp backend

# Configure the database in the .env file
# Replace username, password, host, port, and app with your actual database credentials
DATABASE_URL=mysql://username:password@host:port/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4

# Create the database
symfony console doctrine:database:create

# Generate a new entity
symfony console make:entity

# Create a new migration based on changes in the entity
symfony console make:migration

# Apply the generated migration to the database
symfony console make:migration:migrate

# Generate a new controller
symfony console make:controller

# Install NelmioCorsBundle
composer require nelmio/cors-bundle

# Configure NelmioCorsBundle in .\config\packages\nelmio_cors.yaml

# Replace '^/controller' with your actual path
paths:
    '^/controller':
        origin_regex: true
        allow_origin: ['*']
        allow_headers: ['Content-Type', 'Authorization']
        allow_methods: ['GET', 'POST']
        max_age: 3600


# Start the Symfony development server
symfony server:start


# Create a new React project using Vite
npm create vite@latest frontend

# Change to the frontend directory
cd frontend

# Install a specific version of Vite (replace with your desired version)
npm install vite@4.4.0

# Instal router bundle
npm i react-router-dom

# Instal redux
npm install @reduxjs/toolkit react-redux

# create Slice
```
slices/ApiSlice.js

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
```
# create store
store.js

import { ApiSlice } from "./slices/Apislice"
import { configureStore } from '@reduxjs/toolkit';


export default configureStore({
    reducer: {
        'Api' : ApiSlice.reducer,
    },
    middleware: (getDefaultMiddleware) => {
        return getDefaultMiddleware().concat(ApiSlice.middleware)
    }
})

# main.jsx

import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import { Provider } from 'react-redux'
import './styles/index.scss'
import store from './store.js'

ReactDOM.createRoot(document.getElementById('root')).render(
  <Provider store={store}>
    <App />
  </Provider>,
)


# app.jsx 

import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import { useMemo, useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'
import Layout from './components/Layout';

function App() {
  const router = useMemo(() => {
    return createBrowserRouter([
      {
        path: '',
        element: <Layout content =''/>
      }
    ])
  }, [])

  return (
    <>
     <RouterProvider router={router}/>
    </>
  )
}

export default App


# Start the development server for the React app
npm run dev