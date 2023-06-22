import React, { useEffect, useState } from 'react'
import Container from 'react-bootstrap/esm/Container'
import Spinner from 'react-bootstrap/esm/Spinner';
import Table from 'react-bootstrap/esm/Table'
import axiosClient from '../axios-client';
import Button from 'react-bootstrap/esm/Button';
import Row from 'react-bootstrap/esm/Row';
import Col from 'react-bootstrap/esm/Col';
import Form from 'react-bootstrap/Form';

const Devices = () => {
    const [datas, setData] = useState([]);
    const [tempDatas, setTempData] = useState([]);
    const [room, setRoom] = useState("All");
    const [search, setSearch] = useState("");

    const [currentPage, setCurrentPage] = useState(1);
    const [datasPerPage] = useState(7);

    function GenerateData(room, search) {
        if (room !== "All") {
            return datas
                .filter((d) => d.roomName === room)
                .map((d) => {
                    return {
                        ...d,
                        deviceNames: d.deviceNames.filter((name) =>
                            name.toLowerCase().startsWith(search.toLowerCase())
                        ),
                    };
                });
        }
        return datas.map((d) => {
            return {
                ...d,
                deviceNames: d.deviceNames.filter((name) =>
                    name.toLowerCase().startsWith(search.toLowerCase())
                ),
            };
        });
    }


    useEffect(() => {
        axiosClient
            .get('/ListRooms')
            .then((response) => {
                setData(response.data);
                setTempData(response.data);
            })
            .catch((error) => console.error(error));

    }, [])

    useEffect(() => {
        if (room == "All" && search == "") {
            setTempData(datas)
        } else {
            setTempData(() => GenerateData(room, search))
        }
    }, [room, search])



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
            {datas.length == 0 ? (
                <>
                    <p className="fs-5">Please wait we are fetching the data</p>
                    <Spinner animation="border" variant="success" />
                </>
            ) : (
                <>
                    <div className="my-3">
                        <Row className="align-items-center justify-content-center">
                            <Col sm={3} className="my-1">
                                <Form.Control type="text" placeholder="Enter Name Of Device..." onChange={(event) => setSearch(event.target.value)} />
                            </Col>
                            <Col xs="auto">
                                <b>Room : </b>
                            </Col>
                            <Col xs="auto" className="my-1">
                                <Form.Select aria-label="Devices List" onChange={(event) => setRoom(event.target.value)}>
                                    <option value="All" selected>
                                        All
                                    </option>
                                    {datas.map((d) => {
                                        return (
                                            <option value={d.roomName} key={d.id}>
                                                {d.roomName}
                                            </option>
                                        );
                                    })}
                                </Form.Select>

                            </Col>
                        </Row>
                    </div>
                    <Table striped bordered hover>
                        <thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Device Names</th>
                            </tr>
                        </thead>
                        <tbody>
                            {currentDatas.map((d) => {
                                return (
                                    <tr key={d.id}>
                                        <td>{d.roomName}</td>
                                        <td>
                                            {d.deviceNames.map(deviceName => (
                                                <>
                                                    <span key={deviceName}>{deviceName}</span><br />
                                                </>
                                            ))}
                                        </td>
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
                </>
            )}
        </Container>
    )
}

export default Devices