import React from "react";
import axios from 'axios';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import SendIcon from '@mui/icons-material/Send';

const Input = ({ dialogId, getMessages, userId, message, setMessage, setDialogId }) => {

    const sendMessage = () => {
        var apiHost = 'http://cars/wp-json';
        axios({
            method: 'POST',
            url: apiHost + `/wm/v1/send_message`,
            params: {
                message: message,
                user_id: userId,
                dialog_id: dialogId,
            }
        }).then((response) => {
            if (response.data === 200) {
                console.log('message is sent');
            } else if (response.data === 300) {
                console.log('error send message');
            } else {
                setDialogId(String(response.data))
            }

            getMessages()
            setMessage('')
        }).catch(function (err) {
            console.log(err);
        });
    }

    return (
        <div className="messanger__input">
            <TextField label="Message" multiline rows={3} sx={{ width: '100%' }} value={message} onChange={(e) => setMessage(e.target.value)} />
            <Button onClick={() => sendMessage()} variant="contained" endIcon={<SendIcon />}>Send</Button>
        </div>
    );
}

export default Input