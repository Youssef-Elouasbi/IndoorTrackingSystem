import React from 'react'
import { Navigate, Outlet } from 'react-router-dom'
import { useStateContext } from '../contexts/StateContext'

const GuestLayout = () => {
    const { token } = useStateContext()
    // if (token) {
    //     return <Navigate to="/" />
    // }
    return token != null ? <Navigate to="/" /> :
        (
            //div>
            <div className='login-signup-form'>
                <div className="form">
                    <Outlet />
                </div>
            </div>
            // </div>
        )
}

export default GuestLayout