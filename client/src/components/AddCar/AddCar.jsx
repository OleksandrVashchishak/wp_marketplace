import axios from 'axios';
import React from "react";

import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Snackbar from '@mui/material/Snackbar';
import MuiAlert from '@mui/material/Alert';

const Alert = React.forwardRef(function Alert(props, ref) {
    return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
});

const AddCar = () => {
    const route = "http://cars/wp-json/wm/v1/add-car"
    const [open, setOpen] = React.useState(false);
    const [brand, setBrand] = React.useState('')
    const [model, setModel] = React.useState('')
    const [year, setYear] = React.useState('')
    const [mileage, setMileage] = React.useState('')
    const [price, setPrice] = React.useState('')


    const submitCar = () => {
        const addCarRoute = `${route}/${brand}/${model}/${year}/${mileage}/${price}`;
        axios.get(addCarRoute).then((response) => {
            if (response.data === 200) {
                setOpen(true);
            }
        });
    }

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setOpen(false);
    };

    return (
        <div className='add-car-form'>
            <h3>Add new car</h3>
            <TextField value={model} onChange={(e) => setModel(e.target.value)} label="Model" variant="standard" />
            <br />
            <TextField value={brand} onChange={(e) => setBrand(e.target.value)} label="Brand" variant="standard" />
            <br />
            <TextField value={year} onChange={(e) => setYear(e.target.value)} label="Year" variant="standard" />
            <br />
            <TextField value={mileage} onChange={(e) => setMileage(e.target.value)} label="Mileage" variant="standard" />
            <br />
            <TextField value={price} onChange={(e) => setPrice(e.target.value)} label="Price $" variant="standard" />
            <br /> <br />

            <Button onClick={() => submitCar()} variant="outlined">Add new car</Button>

            <Snackbar open={open} autoHideDuration={6000} onClose={handleClose}>
                <Alert onClose={handleClose} severity="success" sx={{ width: '100%' }}>
               You successfully add new car
                </Alert>
            </Snackbar>
        </div>
    );

}

export default AddCar