import React from "react";
import axios from 'axios';
import { Link } from "react-router-dom";
import CreateNewDialog from './CreateNewDialog'

const Dialogs = ({ setDialogId, userId, setMessage, dialogId }) => {
    const [dialogs, setDialogs] = React.useState('');
    const [recipients, setRecipients] = React.useState([])

    const getRecipients = (dialogs) => {
        const arrayRec = []
        dialogs.forEach(dialog => {
            if (dialog.from_id === userId) {
                arrayRec.push(dialog.to_id)
            } else {
                arrayRec.push(dialog.from_id)
            }
        })
        setRecipients(arrayRec)
    }

    const setStateDialog = (id) => {
        setDialogId(id)
        setMessage('')
    }

    const getDialogs = () => {
        var apiHost = 'http://cars/wp-json';
        axios({
            method: 'POST',
            url: apiHost + `/wm/v1/get_dialogs`,
            params: {
                from_id: userId,
                to_id: userId,
            }
        }).then((response) => {
            setDialogs(response.data)
            getRecipients(response.data)

        }).catch(function (err) {
            console.log(err);
        });
    }

    React.useEffect(() => {
        getDialogs()
    }, [dialogId]);

    const getFirstLetter = (name) => name.split('')[0]

    return (
        <>
            <div className="messanger__users">
                <CreateNewDialog setDialogId={setDialogId} setMessage={setMessage} recipients={recipients} />
                <div className="messanger__users-wrapper">
                    {dialogs && dialogs.map(dialog => (
                        <Link onClick={() => setStateDialog(dialog.ID)} key={dialog.ID} to={`/messanger?id=${dialog.ID}`}>
                            <div className="messanger__user">
                                <div className="messanger__user-img " >
                                    {getFirstLetter(dialog.from_id === userId ? dialog.to_name : dialog.from_name)}
                                </div>
                                <span className="messanger__user-name">
                                    {dialog.from_id === userId ? dialog.to_name : dialog.from_name}
                                </span>
                            </div>
                        </Link>
                    ))}
                </div>
            </div>
        </>
    );
}

export default Dialogs