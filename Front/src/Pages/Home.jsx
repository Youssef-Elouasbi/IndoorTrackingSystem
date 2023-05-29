import Container from 'react-bootstrap/Container';
import Table from 'react-bootstrap/Table';
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import Row from 'react-bootstrap/Row';
import { useEffect, useState } from 'react';
import axiosClient from '../axios-client';
const Home = () => {
    const [status, setStatus] = useState('LEARNING')
    const [devices, setDevices] = useState([]);
    const [selectedDevice, setSelectedDevice] = useState('');

    const handleSubmit = (event) => {
        event.preventDefault();
        // Do something with the selectedDevice value, like sending it to an API
        console.log(selectedDevice);
    };

    const handleDeviceChange = (event) => {
        setSelectedDevice(event.target.value);
    };

    useEffect(() => {
        axiosClient.get('/devices')
            .then(response => setDevices(response.data))
            .catch(error => console.error(error));
    }, [])
    return (
        <Container className='mt-5 text-center'>
            <h1 className="fs-1">Indoor Traking System</h1>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Devices</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        devices.map((d) => {
                            return (
                                <tr>
                                    <td>{d.id}</td>
                                    <td>{d.Name}</td>
                                    <td>{d.status}</td>
                                </tr>
                            )
                        })
                    }
                </tbody>
            </Table>
            <Form onSubmit={handleSubmit}>
                <Row className="align-items-center justify-content-center">
                    <Col sm={3} className="my-1">
                        <Form.Select aria-label="Devices List" value={selectedDevice} onChange={handleDeviceChange}>
                            <option>Devices List</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </Form.Select>
                    </Col>
                    <Col xs="auto" className="my-1">
                        <Button type="submit" variant={status == 'LEARNING' ? 'success' : 'danger'}>Capturer</Button>
                    </Col>
                </Row>
            </Form>
        </Container>
    )
}

export default Home