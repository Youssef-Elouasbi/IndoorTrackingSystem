import React from 'react'
import Container from 'react-bootstrap/esm/Container'
import { Link } from 'react-router-dom'

const Login = () => {
    const onSubmit = (e) => {
        e.preventDefault()
    }
    return (
        <form onSubmit={onSubmit} className='animated fadeInDown'>
            <h1 className="title">
                Login Into Your Account
            </h1>
            <input type="email" placeholder='Email' />
            <input type="password" placeholder='Password' />
            <button className="btn btn-block">Login</button>
            <p className="message">
                Not Registered? <Link to="/signup">Create an account</Link>
            </p>

        </form>
    )
}

export default Login