import Container from 'react-bootstrap/Container';
import Image from 'react-bootstrap/Image';
import comingImage from '../assets/coming.png';
import Stack from 'react-bootstrap/Stack';
import styled, { keyframes } from 'styled-components';


const Home = () => {

    return (
        <Container className="mt-5 text-center">
            <ImageContainer>
                <Image src={comingImage} width={250} roundedCircle />
            </ImageContainer>
            <a href="https://www.flaticon.com/free-icons/work-in-progress" title="work in progress icons" style={{ fontSize: "10px" }}>
                Work in progress icons created by Freepik - Flaticon
            </a>
            <h1 className="fs-3">Coming Soon ...</h1>
        </Container>
    );
};

const upAndDownAnimation = keyframes`
  0% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0);
  }
`;

const ImageContainer = styled.div`
  animation: ${upAndDownAnimation} 2s infinite;
`;

export default Home;
