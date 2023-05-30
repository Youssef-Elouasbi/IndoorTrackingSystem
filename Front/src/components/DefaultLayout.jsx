import React from 'react'
import { Link, Navigate, Outlet } from 'react-router-dom'
import { useStateContext } from '../contexts/StateContext'
import Container from 'react-bootstrap/Container';
import Navbar from 'react-bootstrap/Navbar';
const DefaultLayout = () => {
    const { user, token } = useStateContext()
    // if (!token) {
    //     return <Navigate to="/login" />
    // }
    const onLogout = (event) => {
        event.preventDefault()
    }
    return (
        <div id='defaultLayout'>
            <div>
                <Navbar>
                    <Container>
                        <Navbar.Brand href="#home">PFA</Navbar.Brand>
                        <Navbar.Toggle />
                        <Navbar.Collapse className="justify-content-end">
                            <Navbar.Text>
                                Signed in as: <b> {user.name}</b>&nbsp;
                                <a href="#" onClick={onLogout} className='btn-logout'>Logout</a>
                            </Navbar.Text>
                        </Navbar.Collapse>
                    </Container>
                </Navbar>
                <main>
                    <Outlet />
                </main>
            </div>
        </div >
    )
}

export default DefaultLayout