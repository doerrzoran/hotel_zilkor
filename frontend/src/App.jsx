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
