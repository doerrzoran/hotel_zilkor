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



function App() {
 
  const router = useMemo(() => {
    return createBrowserRouter([
      {
        path: '',
        element: <Layout content =  {<Home/>} />
      },
      {
        path: 'backoffice/rooms',
        element: <Rooms/>
      },
      {
        path: 'backoffice/bookings',
        element: <Bookings/>
      },
      {
        path: 'new/account',
        element: <CreateAccount/>
      },
      {
        path: 'login',
        element: <Login/>
      },
      {
        path: 'my/booking',
        element: <Layout content =  {<User/>} />
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
