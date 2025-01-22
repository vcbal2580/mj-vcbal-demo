import React, { useState } from 'react';
import styled from 'styled-components';

const InputContainer = styled.div`
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    max-width: 600px;
`;

const Input = styled.input`
    width: 100%;
    padding: 15px 20px;
    border-radius: 25px;
    border: 2px solid #e0e0e0;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s;
    
    &:focus {
        border-color: #007bff;
    }
`;

const ChatInput = ({ onSend }) => {
    const [message, setMessage] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        if (message.trim()) {
            onSend(message);
            setMessage('');
        }
    };

    return (
        <InputContainer>
            <form onSubmit={handleSubmit}>
                <Input
                    type="text"
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                    placeholder="输入描述..."
                />
            </form>
        </InputContainer>
    );
};

export default ChatInput; 