import React, { useState, useEffect } from "react";
import styled from "styled-components";
import ChatInput from "./ChatInput";
import MessageBubble from "./MessageBubble";
import ModelSelector from "./ModelSelector";
import DiscordOptions from "./DiscordOptions";
import ModelInfo from "./ModelInfo";
import { sendMessage } from "../services/api";

const Container = styled.div`
    height: 100vh;
    padding: 20px;
    background-color: #f5f5f5;
`;

const MessagesContainer = styled.div`
    padding-bottom: 100px;
    overflow-y: auto;
    height: calc(100vh - 100px);
`;

const ChatContainer = () => {
    const [messages, setMessages] = useState([]);
    const [loading, setLoading] = useState(false);
    const [selectedModel, setSelectedModel] = useState('gpt-3.5-turbo');
    const [models, setModels] = useState({});
    const [currentModelDetails, setCurrentModelDetails] = useState(null);
    const [discordOptions, setDiscordOptions] = useState({
        template: 'default',
        user_id: '',
        channel_id: ''
    });

    const handleSend = async (text) => {
        try {
            setLoading(true);
            setMessages(prev => [...prev, { text, isUser: true }]);
            
            const response = await sendMessage(text, selectedModel, discordOptions);
            
            setCurrentModelDetails(response.data.modelDetails);
            
            setMessages(prev => [...prev, {
                text: `${response.data.usedGpt 
                    ? `使用模型 ${response.data.model}\n优化后的提示词: ${response.data.prompt}`
                    : `使用直接模式，原始描述: ${response.data.prompt}`}\n\n发送到 Discord 频道: ${response.data.discordChannelId}\n格式化提示词: ${response.data.formattedPrompt}`,
                modelDetails: response.data.modelDetails,
                isUser: false
            }]);
        } catch (error) {
            setMessages(prev => [...prev, {
                text: '发生错误: ' + error,
                isUser: false
            }]);
        } finally {
            setLoading(false);
        }
    };

    return (
        <Container>
            <ModelSelector 
                selectedModel={selectedModel}
                onModelChange={setSelectedModel}
                models={models}
            />
            <ModelInfo 
                modelDetails={currentModelDetails}
                isActive={!loading}
            />
            <DiscordOptions 
                options={discordOptions}
                onChange={setDiscordOptions}
            />
            <MessagesContainer>
                {messages.map((msg, idx) => (
                    <MessageBubble
                        key={idx}
                        message={msg.text}
                        modelDetails={msg.modelDetails}
                        image={msg.image}
                        isUser={msg.isUser}
                    />
                ))}
                {loading && <MessageBubble message="生成中..." isUser={false} />}
            </MessagesContainer>
            <ChatInput onSend={handleSend} />
        </Container>
    );
};

export default ChatContainer;