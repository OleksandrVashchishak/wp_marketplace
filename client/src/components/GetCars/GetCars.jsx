import axios from 'axios';
import React from "react";
import GetCarsItem from './GetCarsItem';

import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';


const GetCars = ({ isLogin }) => {
    const getCarsRoute = "http://cars/wp-json/wm/v1/get-cars/1";
    const [getCars, setCars] = React.useState(null);

    React.useEffect(() => {
        axios.get(getCarsRoute).then((response) => {
            setCars(response.data);
        });
    }, []);

    return (
        <div className="App">
            {getCars && <TableContainer component={Paper}>
                <Table sx={{ minWidth: 650 }} aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell>Brand</TableCell>
                            <TableCell align="right">Model</TableCell>
                            <TableCell align="right">Year</TableCell>
                            <TableCell align="right">Mileage</TableCell>
                            <TableCell align="right">Price</TableCell>
                            {isLogin && <TableCell align="right">Edit</TableCell>}
                            {isLogin && <TableCell align="right">Remove</TableCell>}
                        </TableRow>
                    </TableHead>
                    <TableBody>

                        {getCars && getCars.map(car => (
                            <GetCarsItem key={car.ID} carInfo={car} isLogin={isLogin} />
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>}


        </div>
    );
}

export default GetCars