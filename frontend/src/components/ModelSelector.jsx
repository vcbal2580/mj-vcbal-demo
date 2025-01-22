import React from 'react';
import styled from 'styled-components';

const SelectContainer = styled.div`
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
`;

const Select = styled.select`
    padding: 8px 12px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    background-color: white;
    font-size: 14px;
    cursor: pointer;
    outline: none;
    
    &:focus {
        border-color: #007bff;
    }
`;

const ServiceBadge = styled.span`
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 8px;
    background-color: ${props => {
        switch (props.service) {
            case 'openai': return '#10a37f';
            case 'gemini': return '#4285f4';
            default: return '#666';
        }
    }};
    color: white;
`;

const ModelSelector = ({ selectedModel, onModelChange, models }) => (
    <SelectContainer>
        <Select value={selectedModel} onChange={(e) => onModelChange(e.target.value)}>
            {Object.entries(models).map(([id, model]) => (
                <option key={id} value={id}>
                    {model.name}
                    {model.service !== 'none' && ` (${model.service})`}
                </option>
            ))}
        </Select>
    </SelectContainer>
);

export default ModelSelector; 