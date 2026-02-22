export type Message = {
    id: number;
    conversation_id: number;
    role: 'user' | 'assistant' | 'system';
    content: string;
    created_at: string;
};

export type Conversation = {
    id: number;
    title: string;
    updated_at: string;
    messages?: Message[];
};

export type ChatPageProps = {
    conversations: Conversation[];
};

export type SSEEvent = {
    event: string;
    data: unknown;
};

export type UserMessageEvent = {
    id: number;
    role: 'user';
    content: string;
    created_at: string;
};

export type ChunkEvent = {
    content: string;
};

export type CompleteEvent = {
    id: number;
    role: 'assistant';
    content: string;
    created_at: string;
};

export type TitleUpdatedEvent = {
    title: string;
};

export type ErrorEvent = {
    error: string;
};
