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
import Guests from './components/backoffice/Guests';
import HostelDetail from './components/HostelDetail';
import AddHostel from './components/backoffice/AddHostel';
import AboutUs from './components/AboutUs';



function App() {
 
  const router = useMemo(() => {
    return createBrowserRouter([
      {
        path: '',
        element: <Layout content =  {<Home/>} />
      },
      {
        path: 'backoffice',
        element: <Backoffice/>
      },
      {
        path: '/backoffice/rooms',
        element: <Backoffice content={<Rooms/>} />
      },
      {
        path: '/backoffice/bookings',
        element: <Backoffice content={<Bookings/>} />
      },
      {
        path: '/backoffice/hostels',
        element: <Backoffice content={<Hostels/>} />
      },
      {
        path: '/backoffice/guests',
        element: <Backoffice content={<Guests/>} />
      },
      {
        path: '/backoffice/add/hostel',
        element: <Backoffice content={<AddHostel/>} />
      },
      {
        path: 'new/account',
        element: <Layout content =  {<CreateAccount/>} />
      },
      {
        path: '/a/propos/de/nous',
        element: <Layout content =  {<AboutUs/>} />
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
        path: '/hostels',
        element: <Layout content =  {<HostelDetail/>} />
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
