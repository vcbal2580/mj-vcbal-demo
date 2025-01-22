import React from 'react';
import styled from 'styled-components';

const Bubble = styled.div`
    display: flex;
    margin: 10px 0;
    flex-direction: column;
    align-items: ${props => props.isUser ? 'flex-end' : 'flex-start'};
`;

const Content = styled.div`
    max-width: 70%;
    padding: 15px;
    border-radius: 15px;
    background-color: ${props => props.isUser ? '#007bff' : '#f0f0f0'};
    color: ${props => props.isUser ? 'white' : 'black'};
`;

const ModelTag = styled.div`
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    padding: 2px 6px;
    background-color: #e0e0e0;
    border-radius: 4px;
    display: inline-block;
`;

const Image = styled.img`
    max-width: 300px;
    border-radius: 10px;
    margin-top: 5px;
`;

const MessageBubble = ({ message, modelDetails, isUser, image }) => (
    <Bubble isUser={isUser}>
        <Content isUser={isUser}>
            {message}
            {modelDetails && !isUser && (
                <ModelTag>
                    {modelDetails.name} (Temperature: {modelDetails.temperature})
                </ModelTag>
            )}
        </Content>
        {image && <Image src={image} alt="Generated" />}
    </Bubble>
);

export default MessageBubble; 