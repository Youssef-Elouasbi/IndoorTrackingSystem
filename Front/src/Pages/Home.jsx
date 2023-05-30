import Container from 'react-bootstrap/Container';
import Toast from 'react-bootstrap/Toast';
import Spinner from 'react-bootstrap/Spinner';
import Table from 'react-bootstrap/Table';
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import Row from 'react-bootstrap/Row';
import { useEffect, useState } from 'react';
import axiosClient from '../axios-client';
const Home = () => {
    const [showMessage, setShowMessage] = useState(false)
    const [devices, setDevices] = useState([]);
    const [selectedDevice, setSelectedDevice] = useState({});
    const [message, setMessage] = useState('');

    const toggleShow = () => setShowMessage(false)

    const handleSubmit = (event) => {
        event.preventDefault();
        const Status = selectedDevice.Status == "USED" ? 'LEARNING' : 'USED'
        axiosClient.put(`/devices/${selectedDevice.MAC}/status/${Status}`)
            .then(response => {
                setMessage(response.data.message)
                setShowMessage(true)
                setSelectedDevice(prevDevice => ({ ...prevDevice, Status: Status }));
                setDevices(prevDevices =>
                    prevDevices.map(device => {
                        return device.id == selectedDevice.id ? { ...device, Status: Status } : device
                    }))
            })
            .catch(error => {
                console.error(error);
            });
    };

    const handleDeviceChange = (event) => {
        setSelectedDevice(JSON.parse(event.target.value));

    };

    useEffect(() => {
        axiosClient.get('/devices')
            .then(response => {
                setDevices(response.data)
                setSelectedDevice(devices[0])
            })
            .catch(error => console.error(error));

    }, [])
    useEffect(() => {
        if (devices.length > 0 && !selectedDevice) {
            setSelectedDevice(devices[0]);
        }
    }, [devices]);
    return (
        <Container className='mt-5 text-center'>
            <h1 className="fs-1">Indoor Traking System</h1>
            <Toast show={showMessage} onClose={toggleShow} className='mb-3 mt-3'>
                <Toast.Header>
                    <strong className="me-auto">Update</strong>
                </Toast.Header>
                <Toast.Body> {message}</Toast.Body>
            </Toast>
            {
                devices.length == 0 ? <Spinner animation="border" variant="success" /> :
                    <>
                        <Table striped bordered hover>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Devices</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    devices.map((d) => {
                                        return (
                                            <tr key={d.id}>
                                                <td>{d.id}</td>
                                                <td>{d.Name}</td>
                                                <td>{d.Status}</td>
                                                <td>{d.latest_data_entry != null ? d.latest_data_entry.log_at : 'No Record Yet'}</td>
                                            </tr>
                                        )
                                    })
                                }
                            </tbody>
                        </Table>
                        <Form onSubmit={handleSubmit}>
                            <Row className="align-items-center justify-content-center">
                                <Col sm={3} className="my-1">
                                    <Form.Select aria-label="Devices List" onChange={handleDeviceChange}>
                                        {
                                            devices.map((d) => {
                                                return (
                                                    <option value={JSON.stringify(d)} key={d.id} >{d.Name}</option>

                                                )
                                            })
                                        }
                                    </Form.Select>
                                </Col>
                                <Col xs="auto" className="my-1">
                                    <Button type="submit" variant={selectedDevice?.Status == 'USED' ? 'success' : 'danger'}>Capturer</Button>
                                </Col>
                            </Row>
                        </Form>
                    </>
            }

        </Container>
    )
}

export default Home