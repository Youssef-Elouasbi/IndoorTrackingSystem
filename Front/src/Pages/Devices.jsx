import React, { useEffect, useRef, useState } from 'react';
import Container from 'react-bootstrap/Container';
import Spinner from 'react-bootstrap/Spinner';
import Table from 'react-bootstrap/Table';
import axiosClient from '../axios-client';
import Button from 'react-bootstrap/Button';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';

const Devices = () => {
    const [datas, setDatas] = useState([]);
    const [tempDatas, setTempDatas] = useState([]);
    const [room, setRoom] = useState('All');
    const [rooms, setRooms] = useState([]);
    const [search, setSearch] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [currentDateTime, setCurrentDateTime] = useState(new Date());
    const [datasPerPage] = useState(11);

    const fetchData = () => {
        setCurrentDateTime(new Date("1/1/2015"));
        axiosClient
            .get('/ListRooms')
            .then((response) => {
                setDatas(response.data.datas);
                setRooms(response.data.rooms);
                setCurrentDateTime(new Date());
            })
            .catch((error) => console.error(error));
    };
    useEffect(() => {
        fetchData();
        const interval = setInterval(fetchData, 600000);
        //just in case we moved into another component we don't want this effect to be called
        return () => {
            clearInterval(interval);
        };
    }, []);
    const formattedDateTime = currentDateTime.toLocaleString('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    useEffect(() => {
        const filteredData = datas.filter((d) => {
            const nameMatch = d.Name.toLowerCase().startsWith(search.toLowerCase());
            const roomMatch = room === 'All' || d.room.Name === room;
            return nameMatch && roomMatch;
        });
        setTempDatas(filteredData);
    }, [datas, room, search]);

    const handleSearchChange = (event) => {
        setSearch(event.target.value);
    };

    const handleRoomChange = (event) => {
        setRoom(event.target.value);
    };

    const indexOfLastData = currentPage * datasPerPage;
    const indexOfFirstData = indexOfLastData - datasPerPage;
    const currentDatas = tempDatas.slice(indexOfFirstData, indexOfLastData);

    const paginate = (pageNumber) => {
        setCurrentPage(pageNumber);
    };

    const pageNumbers = [];
    for (let i = 1; i <= Math.ceil(tempDatas.length / datasPerPage); i++) {
        pageNumbers.push(i);
    }

    return (
        <Container className="mt-5 text-center">
            {datas.length === 0 ? (
                <>
                    <p className="fs-5">Please wait while we fetch the data</p>
                    <Spinner animation="border" variant="success" />
                </>
            ) : (
                <>
                    <div className="my-3">
                        <Row className="align-items-center justify-content-center">
                            <Col sm={3} className="my-1">
                                <Form.Control
                                    type="text"
                                    placeholder="Enter Name Of Device..."
                                    onChange={handleSearchChange}
                                />
                            </Col>
                            <Col xs="auto">
                                <b>Room: </b>
                            </Col>
                            <Col xs="auto" className="my-1">
                                <Form.Select aria-label="Devices List" onChange={handleRoomChange} defaultValue="All">
                                    <option value="All">All</option>
                                    {rooms.map((r) => (
                                        <option value={r.Name} key={r.id}>
                                            {r.Name}
                                        </option>
                                    ))}
                                </Form.Select>
                            </Col>
                            <Col xs="auto">
                                <b>{currentDateTime.getFullYear() == 2015 ? (
                                    <>
                                        <Spinner animation="border" variant="success" />
                                    </>
                                ) :
                                    `Last Update: ${formattedDateTime}`
                                }
                                </b>
                            </Col>
                        </Row>
                    </div>
                    <Table striped bordered hover>
                        <thead>
                            <tr>
                                <th className="text-start">Device Name</th>
                                <th className="text-center">Room Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            {currentDatas.map((d) => (
                                <tr key={d.id}>
                                    <td className="text-start">{d.Name}</td>
                                    <td className="text-center">{d.room.Name}</td>
                                </tr>
                            ))}
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
                </>
            )}
        </Container>
    );
};

export default Devices;
