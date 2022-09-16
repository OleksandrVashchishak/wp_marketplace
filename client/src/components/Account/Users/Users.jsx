import axios from 'axios';
import React from "react";

const Users = () => {
    const getUsersRoute = "http://cars/wp-json/wm/v1/get-users/-1";
    const [getUsers, setUsers] = React.useState(null);

    React.useEffect(() => {
        axios.get(getUsersRoute).then((response) => {
            setUsers(response.data);
            console.log(response.data);
        });
    }, []);

    return (
        <div className="users-all">
            {getUsers && getUsers.map(user => (
                <div className='user-item' key={user.id}>
                    <div className="user-item-img">
                        {user.name.split('')[0]}
                    </div>
                    <span className="user-item-name">{user.name}</span>
                    <span id={user.id} className="user-item-send">Send message</span>
                </div>

            ))}
        </div>
    );
}

export default Users