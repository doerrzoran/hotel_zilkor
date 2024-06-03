import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import { useMemo } from 'react'

import './App.css'
import Layout from './components/Layout';
import Home from './components/pages/Home';
import Rooms from './components/backoffice/Rooms';

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
    ])
  }, [])

  return (
    <>
     <RouterProvider router={router}/>
     
    </>
  )
}

export default App
