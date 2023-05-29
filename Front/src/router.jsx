import { Navigate, createBrowserRouter } from 'react-router-dom'
import Login from './Pages/Login'
import NotFound from './Pages/NotFound'
import Signup from './Pages/Signup'
import GuestLayout from './components/GuestLayout'
import DefaultLayout from './components/DefaultLayout'

import Home from './Pages/Home'

const router = createBrowserRouter([
    {
        path: '/',
        element: <DefaultLayout />,
        children: [
            {
                path: '/',
                element: <Navigate to="/Home" />
            },
            {
                path: '/Home',
                element: <Home />
            },

        ]
    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/signup',
                element: <Signup />
            },

        ]
    },
    {
        path: '*',
        element: <NotFound />
    },
])

export default router;