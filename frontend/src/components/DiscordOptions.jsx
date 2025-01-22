import React from 'react';
import styled from 'styled-components';

const OptionsContainer = styled.div`
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
`;

const Select = styled.select`
    padding: 8px 12px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    margin-bottom: 10px;
    width: 100%;
    
    &:focus {
        border-color: #007bff;
    }
`;

const Label = styled.label`
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #666;
`;

const DiscordOptions = ({ options, onChange }) => {
    const handleChange = (field, value) => {
        onChange({ ...options, [field]: value });
    };

    return (
        <OptionsContainer>
            <div>
                <Label>提示词模板</Label>
                <Select
                    value={options.template || 'default'}
                    onChange={(e) => handleChange('template', e.target.value)}
                >
                    <option value="default">默认</option>
                    <option value="detailed">详细</option>
                    <option value="artistic">艺术</option>
                    <option value="simple">简单</option>
                </Select>
            </div>
            <div>
                <Label>用户 ID</Label>
                <Select
                    value={options.user_id || ''}
                    onChange={(e) => handleChange('user_id', e.target.value)}
                >
                    <option value="">默认用户</option>
                    <option value="user1">用户 1</option>
                    <option value="user2">用户 2</option>
                </Select>
            </div>
            <div>
                <Label>频道</Label>
                <Select
                    value={options.channel_id || ''}
                    onChange={(e) => handleChange('channel_id', e.target.value)}
                >
                    <option value="">默认频道</option>
                    <option value="channel1">频道 1</option>
                    <option value="channel2">频道 2</option>
                </Select>
            </div>
        </OptionsContainer>
    );
};

export default DiscordOptions; 