import React from "react";

const Messages = ({ messages, userId }) => {

    return (
        <div className="messanger__wrapper">
            {messages && messages.map((message, i) => (
                <div key={i} className='messanger__massage' who={userId == message.user_id ? "my" : 'recipiente'}>
                    {message.message}
                    <span className="messanger__massage-time">
                        {message.time}
                    </span>
                </div>
            ))}
        </div>
    );
}

export default Messages