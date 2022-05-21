import * as React from 'react';
import axios from "axios";
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';
import { useState } from "react";
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Grid from '@mui/material/Grid';
import Container from '@mui/material/Container';
import MenuItem from '@mui/material/MenuItem';

const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 500,
    bgcolor: 'background.paper',
    border: '1px solid #000',
    boxShadow: 5,
    p: 2,
};


const cat = [
    {
        value: '1',
        label: 'Carne Bianca',
    },
    {
        value: '2',
        label: 'Carne Rossa',
    },
    {
        value: '3',
        label: 'Preparati',
    },
];


export default function AddProduct() {
    const [category, setCategory] = React.useState('');


    const [open, setOpen] = React.useState(false);
    const [inputs, setInputs] = useState([]);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({ ...values, [name]: value }));
    }

    const handleCategory = (event) => {
        setCategory(event.target.value);
        handleChange(event);
    };

    const handleSubmit = async (event) => {

        event.preventDefault();
        await axios.post('http://localhost:80/api/products/save', inputs).then(function (response) {
            window.location.reload();
        });
    }

    return (
        <>

            <Button variant="outlined" size="small" onClick={handleOpen}>
                Aggiungi Prodotto
            </Button>

            <Modal
                open={open}
                onClose={handleClose}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <Button onClick={handleClose}>X</Button>

                    <Container component="main" maxWidth="xs">
                        <CssBaseline />
                        <Box
                            sx={{
                                marginTop: 1,
                                display: 'flex',
                                flexDirection: 'column',
                                alignItems: 'center',
                                marginBottom: 1,
                            }}
                        >
                            <Typography component="h1" variant="h5">
                                Aggiungi Prodotto
                            </Typography>
                            <Box component="form" noValidate sx={{ mt: 3 }}>
                                <Grid container spacing={2}>
                                    <Grid item xs={12} sm={6}>
                                        <TextField
                                            name="name"
                                            type="text"
                                            required
                                            fullWidth
                                            label="Nome"

                                            onChange={handleChange}
                                        />
                                    </Grid>
                                    <Grid item xs={15} sm={6}>
                                        <TextField
                                            name="image"
                                            required
                                            fullWidth
                                            label="Percorso foto"
                                            autoFocus
                                            onChange={handleChange}
                                        />
                                    </Grid>
                                    <Grid item xs={12}>
                                        <TextField

                                            fullWidth
                                            size='large'
                                            label="Descrizione"
                                            name="description"
                                            rows={10}
                                            onChange={handleChange}
                                        />
                                    </Grid>
                                    <Grid item xs={6} sm={5}>
                                        <TextField
                                            required
                                            fullWidth
                                            label="Prezzo al Kg"
                                            name="price"
                                            onChange={handleChange}
                                        />
                                    </Grid>
                                    <Grid item xs={12} sm={5}>
                                        <TextField
                                            select
                                            label="Categoria"
                                            value={category}
                                            onChange={handleCategory}
                                            name="id_category"
                                            fullWidth
                                            required
                                        >
                                            {cat.map((option) => (
                                                <MenuItem key={option.value} value={option.value}>
                                                    {option.label}
                                                </MenuItem>
                                            ))}
                                        </TextField>
                                    </Grid>
                                </Grid>
                                <Button
                                    type="submit"
                                    fullWidth
                                    variant="contained"
                                    sx={{ mt: 3, mb: 2 }}
                                    onClick={handleSubmit}
                                >
                                    Aggiungi
                                </Button>
                            </Box>
                        </Box>
                    </Container>

                </Box>
            </Modal>
        </>

    );
}