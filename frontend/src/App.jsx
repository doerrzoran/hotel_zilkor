import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import { useEffect, useMemo } from 'react'

import './App.css'
import Layout from './components/Layout';
import Home from './components/pages/Home';
import Rooms from './components/backoffice/Rooms';
import CreateAccount from './components/pages/divers/CreateAccount';
import Login from './components/pages/divers/Login';
import Bookings from './components/backoffice/Bookings';
import User from './components/pages/User';
import NotFound from './components/pages/divers/NotFound';
import Hostels from './components/backoffice/Hostels';
import Backoffice from './components/backoffice/Backoffice';



function App() {
 
  const router = useMemo(() => {
    return createBrowserRouter([
      {
        path: '',
        element: <Layout content =  {<Home/>} />
      },
      {
        path: 'backoffice',
        element: <Layout content =  {<Backoffice/>} />
      },
      {
        path: '/backoffice/rooms',
        element: <Rooms/>
      },
      {
        path: '/backoffice/bookings',
        element: <Bookings/>
      },
      {
        path: '/backoffice/hostels',
        element: <Hostels/>
      },
      {
        path: 'new/account',
        element: <Layout content =  {<CreateAccount/>} />
      },
      {
        path: 'login',
        element: <Layout content =  {<Login/>} />
      },
      {
        path: 'my/booking',
        element: <Layout content =  {<User/>} />
      },
      {
        path: '*',
        element: <NotFound/>
      },
    ])
  }, [])

  return (
    <>
        <RouterProvider router={router} />
    </>
  )
}

export default App
