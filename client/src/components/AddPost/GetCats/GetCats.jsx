import axios from 'axios';
import React from "react";
import Checkbox from '@mui/material/Checkbox';
import FormControlLabel from '@mui/material/FormControlLabel';
import FormGroup from '@mui/material/FormGroup';

const GetCats = ({checkedCats, setCheckedCats}) => {
    const [cats, setCats] = React.useState([]);

    React.useEffect(() => {
        const route = `http://cars/wp-json/wp/v2/categories`
        axios.get(route)
            .then(response => {
                setCats(response.data)
            }).catch(err => {
                console.log(err);
            })
    }, []);

    const handleChange = (event, id) => {
        if (event.target.checked) {
            setCheckedCats(cats => [...cats, id]);
        } else {
            setCheckedCats(checkedCats.filter(check => check !== id));
        }
    };

    return (
        <div className="login-wrapper">
            <FormGroup>
                {cats && cats.map(cat => (
                    <FormControlLabel control={<Checkbox onChange={(e) => handleChange(e, cat.id)} />} key={cat.id} label={cat.name} />
                ))}
            </FormGroup>

        </div>
    );
}

export default GetCats