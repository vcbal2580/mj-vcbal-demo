import React from 'react';
import styled from 'styled-components';

const InfoContainer = styled.div`
    position: fixed;
    top: 20px;
    right: 200px;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 300px;
    z-index: 1000;
`;

const Title = styled.h3`
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #333;
`;

const Detail = styled.p`
    margin: 5px 0;
    font-size: 14px;
    color: #666;
`;

const Badge = styled.span`
    display: inline-block;
    padding: 2px 6px;
    border-radius: 4px;
    background-color: ${props => props.active ? '#4CAF50' : '#f0f0f0'};
    color: ${props => props.active ? 'white' : '#666'};
    font-size: 12px;
    margin-left: 8px;
`;

const ServiceIcon = styled.div`
    width: 20px;
    height: 20px;
    display: inline-block;
    margin-right: 8px;
    vertical-align: middle;
    background-image: url(${props => {
        switch (props.service) {
            case 'openai': return '/openai-icon.png';
            case 'gemini': return '/gemini-icon.png';
            default: return '/default-icon.png';
        }
    }});
    background-size: contain;
    background-repeat: no-repeat;
`;

const ModelInfo = ({ modelDetails, isActive }) => {
    if (!modelDetails) return null;

    return (
        <InfoContainer>
            <Title>
                <ServiceIcon service={modelDetails.service} />
                {modelDetails.name}
                <Badge active={isActive}>
                    {isActive ? '使用中' : '待机'}
                </Badge>
            </Title>
            <Detail>服务: {modelDetails.service.toUpperCase()}</Detail>
            <Detail>最大 Tokens: {modelDetails.maxTokens}</Detail>
            <Detail>Temperature: {modelDetails.temperature}</Detail>
            <Detail>Model ID: {modelDetails.id}</Detail>
        </InfoContainer>
    );
};

export default ModelInfo; 