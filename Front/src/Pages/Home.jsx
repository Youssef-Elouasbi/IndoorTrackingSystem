import Container from 'react-bootstrap/Container';
import Toast from 'react-bootstrap/Toast';
import Spinner from 'react-bootstrap/Spinner';
import Table from 'react-bootstrap/Table';
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import Row from 'react-bootstrap/Row';
import Modal from 'react-bootstrap/Modal';
import { useEffect, useState } from 'react';
import axiosClient from '../axios-client';

const Home = () => {
    const [showMessage, setShowMessage] = useState(false);
    const [devices, setDevices] = useState([]);
    const [selectedDevice, setSelectedDevice] = useState({});
    const [message, setMessage] = useState('');
    const [waitUpdate, setWaitUpdate] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [Rooms, setRooms] = useState([]);
    const [selectedRoom, setSelectedRoom] = useState(null);
    const [waitDelete, setWaitDelete] = useState(false);
    const [showMessageRoom, setShowMessageRoom] = useState(false);
    const [messageRoom, setMessageRoom] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [devicesPerPage] = useState(7);

    const toggleShow = () => setShowMessage(false);
    const toggleShowRoom = () => setShowMessageRoom(false);
    const handleModal = () => setShowModal(!showModal);

    const handleSubmit = (event) => {
        event.preventDefault();
        setWaitUpdate(true);
        const Status = selectedDevice.Status == 'USED' ? 'LEARNING' : 'USED';
        axiosClient
            .put(`/devices/${selectedDevice.MAC}/status/${Status}`)
            .then((response) => {
                setMessage(response.data.message);
                setShowMessage(true);
                setSelectedDevice((prevDevice) => ({ ...prevDevice, Status: Status }));
                setDevices((prevDevices) =>
                    prevDevices.map((device) => {
                        return device.id == selectedDevice.id ? { ...device, Status: Status } : device;
                    })
                );
                setWaitUpdate(false);
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handleSubmitRoom = (event) => {
        event.preventDefault();
        setWaitDelete(true);
        axiosClient
            .delete(`/roomdata/${selectedRoom}`)
            .then((response) => {
                setMessageRoom(response.data.message);
                setShowMessageRoom(true);
                setRooms((prevRooms) => prevRooms.filter((r) => r.room != selectedRoom));
                setWaitDelete(false);
            })
            .catch((error) => console.error(error));
    };

    const handleDeviceChange = (event) => {
        setSelectedDevice(JSON.parse(event.target.value));
    };

    const handleRoomChange = (event) => {
        setSelectedRoom(event.target.value);
    };

    useEffect(() => {
        axiosClient
            .get('/devices')
            .then((response) => {
                setDevices(response.data);
                setSelectedDevice(devices[0]);
            })
            .catch((error) => console.error(error));
        axiosClient
            .get('/roomdata/unique')
            .then((response) => {
                setRooms(response.data);
            })
            .catch((error) => console.error(error));
    }, []);

    useEffect(() => {
        if (devices.length > 0 && !selectedDevice) {
            setSelectedDevice(devices[0]);
        }
    }, [devices]);

    useEffect(() => {
        if (Rooms.length > 0 && !selectedRoom) {
            setSelectedRoom(Rooms[0].room + '');
        }
    }, [Rooms]);

    const indexOfLastDevice = currentPage * devicesPerPage;
    const indexOfFirstDevice = indexOfLastDevice - devicesPerPage;
    const currentDevices = devices.slice(indexOfFirstDevice, indexOfLastDevice);

    const paginate = (pageNumber) => {
        setCurrentPage(pageNumber);
    };

    const pageNumbers = [];
    for (let i = 1; i <= Math.ceil(devices.length / devicesPerPage); i++) {
        pageNumbers.push(i);
    }

    return (
        <Container className="mt-5 text-center">
            <h1 className="fs-1">Indoor Traking System</h1>
            <Toast show={showMessage} onClose={toggleShow} className="mb-3 mt-3">
                <Toast.Header>
                    <strong className="me-auto">Update</strong>
                </Toast.Header>
                <Toast.Body> {message}</Toast.Body>
            </Toast>
            {devices.length == 0 ? (
                <>
                    <p className="fs-5">Please wait we are fetching the data</p>
                    <Spinner animation="border" variant="success" />
                </>
            ) : (
                <>
                    <div className="w-100 d-flex justify-content-end">
                        <Button type="submit" variant="danger" className="mt-3 mb-3" onClick={handleModal}>
                            Clear Data
                        </Button>
                    </div>
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
                            {currentDevices.map((d) => {
                                return (
                                    <tr key={d.id}>
                                        <td>{d.id}</td>
                                        <td>{d.Name}</td>
                                        <td>{d.Status}</td>
                                        <td>{d.latest_data_entry != null ? d.latest_data_entry.log_at : 'No Record Yet'}</td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </Table>
                    <div className="pagination">
                        {pageNumbers.map((number) => (
                            <Button
                                key={number}
                                onClick={() => paginate(number)}
                                className={`m-1 ${currentPage === number && 'active'}`}
                            >
                                {number}
                            </Button>
                        ))}
                    </div>
                    <Form onSubmit={handleSubmit}>
                        <Row className="align-items-center justify-content-center">
                            <Col sm={3} className="my-1">
                                <Form.Select aria-label="Devices List" onChange={handleDeviceChange}>
                                    {devices.map((d) => {
                                        return (
                                            <option value={JSON.stringify(d)} key={d.id}>
                                                {d.Name}
                                            </option>
                                        );
                                    })}
                                </Form.Select>
                            </Col>
                            <Col xs="auto" className="my-1">
                                <Button type="submit" variant={selectedDevice?.Status == 'USED' ? 'success' : 'danger'}>
                                    {waitUpdate ? (
                                        <>
                                            Wait <Spinner animation="border" variant="warning" />
                                        </>
                                    ) : (
                                        'Capturer'
                                    )}
                                </Button>
                            </Col>
                        </Row>
                    </Form>
                    <Modal show={showModal} onHide={handleModal}>
                        <Modal.Header closeButton>
                            <Modal.Title>Clear Room Data</Modal.Title>
                        </Modal.Header>
                        <Modal.Body>
                            <Toast show={showMessageRoom} onClose={toggleShowRoom} className="mb-3 mt-3">
                                <Toast.Header>
                                    <strong className="me-auto">Delete</strong>
                                </Toast.Header>
                                <Toast.Body> {messageRoom}</Toast.Body>
                            </Toast>
                            <Form onSubmit={handleSubmitRoom}>
                                <Row className="align-items-center justify-content-center">
                                    <Col sm={3} className="my-1">
                                        <Form.Select aria-label="Room Data List" onChange={handleRoomChange}>
                                            {Rooms.map((r) => {
                                                return (
                                                    <option value={r.room} key={r.id}>
                                                        {r.room}
                                                    </option>
                                                );
                                            })}
                                        </Form.Select>
                                    </Col>
                                    <Col xs="auto" className="my-1">
                                        <Button type="submit" variant="danger">
                                            {waitDelete ? (
                                                <>
                                                    Wait <Spinner animation="border" variant="warning" />
                                                </>
                                            ) : (
                                                'Delete'
                                            )}
                                        </Button>
                                    </Col>
                                </Row>
                            </Form>
                        </Modal.Body>
                    </Modal>
                </>
            )}
        </Container>
    );
};

export default Home;
