import React from "react";
import axios from 'axios';

import Input from './components/Input';
import Dialogs from './components/Dialogs';
import Messages from './components/Messages';
import './messanger.css';



const Messanger = () => {
    const itemIdArr = window.location.href.split('=')
    const userId = localStorage.getItem("user_id");
    const [dialogId, setDialogId] = React.useState(itemIdArr ? itemIdArr[1] : false);
    const [number, setNumber] = React.useState(itemIdArr ? itemIdArr[1] : false);
    const [messages, setMessages] = React.useState('');
    const [message, setMessage] = React.useState('');
    const [scroll, setScroll] = React.useState('');

    const getMessages = () => {
        if (dialogId && dialogId.split('-')[0] !== 'new') {
            var apiHost = 'http://cars/wp-json';
            axios({
                method: 'POST',
                url: apiHost + `/wm/v1/get_messages`,
                params: {
                    id: dialogId,
                }
            }).then((response) => {
                if (response.data) {
                    setMessages(response.data)
                    // setTimeout(() => {
                    //     setNumber(Math.random())
                    // }, 2000)
                }
            }).catch(function (err) {
                console.log(err);
            });
        } else {
            setMessages('')
        }
    }

    React.useEffect(() => {
        getMessages()
    }, [dialogId, number]);

    return (
        <div className="messanger">
            <Dialogs setDialogId={setDialogId} userId={userId} setMessage={setMessage} dialogId={dialogId} />
            {dialogId && <div className="messanger__content">
                <Messages messages={messages} userId={userId} />
                <Input dialogId={dialogId} getMessages={getMessages} userId={userId} setMessage={setMessage} setMessages={setMessages} message={message} setDialogId={setDialogId} />
            </div>}
        </div>
    );
}

export default Messanger