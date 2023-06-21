import React from 'react'
import { Link, Navigate, Outlet } from 'react-router-dom'
import { useStateContext } from '../contexts/StateContext'
import Container from 'react-bootstrap/Container';
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import { LinkContainer } from 'react-router-bootstrap'
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
                <Navbar expand="lg" className="bg-body-tertiary">
                    <Container>
                        <Navbar.Brand>PFA | Indoor Tracking System</Navbar.Brand>
                        <Navbar.Toggle aria-controls="basic-navbar-nav" />
                        <Navbar.Collapse id="basic-navbar-nav">
                            <Nav className="me-auto">
                                <LinkContainer to="/home">
                                    <Nav.Link>Home</Nav.Link>
                                </LinkContainer>
                                <LinkContainer to="/devices">
                                    <Nav.Link>Devices List</Nav.Link>
                                </LinkContainer>
                                <LinkContainer to="/admin">
                                    <Nav.Link>Admin Panel</Nav.Link>
                                </LinkContainer>
                            </Nav>
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