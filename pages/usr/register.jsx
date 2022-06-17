import axios from "axios";
import { useRouter } from "next/router";
import { useState } from "react";
import * as React from 'react';
import styles from "../../styles/Login.module.css";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Link from '@mui/material/Link';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import passwordHash from 'password-hash';

const Register = () => {

  const router = useRouter();
  const [error, setError] = useState();

  const handleSubmit = (event) => {
    event.preventDefault();
    
    axios.post('http://localhost:80/api/user/save', inputs).then(function (response) {
      console.log(response.data.status);

      if (response.data.status !== undefined && response.data.status === 1){
          router.push('/usr/login');
        }
      else {
        setError(true);
      } 
    });
  }

  const [inputs, setInputs] = useState([]);

  const handleChange = (event) => {
    const name = event.target.name;
    const value = event.target.value;
    if (name === "password"){
      value = passwordHash.generate(value);
    }
    setInputs(values => ({ ...values, [name]: value }));
  }


  return (

    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <Box
        sx={{
          marginTop: 8,
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          marginBottom: 8,
        }}
      >

        <Typography component="h1" variant="h5">
          Registrazione
        </Typography>
        <Box component="form" noValidate sx={{ mt: 3 }}>
          <Grid container spacing={2}>
            <Grid item xs={12} sm={6}>
              <TextField
                name="name"
                required
                fullWidth
                label="Nome"
                autoFocus
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12} sm={6}>
              <TextField
                name="surname"
                required
                fullWidth
                label="Cognome"
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12} sm={7}>
              <TextField
                required
                fullWidth
                label="Indirizzo"
                name="address"
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12} sm={5}>
              <TextField
                required
                fullWidth
                label="Città"
                name="city"
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                label="Telefono"
                name="telephone"
                type="tel"
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                label="Email"
                name="email"
                onChange={handleChange}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                name="password"
                label="Password"
                type="password"
                onChange={handleChange}
              />
            </Grid>
          </Grid>
          {error && <span className={styles.error}>Compilare tutti i campi obbligatori!</span>}
          <Button
            type="submit"
            fullWidth
            variant="contained"
            sx={{ mt: 3, mb: 2 }}
            onClick={handleSubmit}
          >
            Registrati
          </Button>
          <Grid container justifyContent="flex-end">
            <Grid item>
              <Link href="/usr/login" variant="body2">
                Hai già un account? Accedi
              </Link>
            </Grid>
          </Grid>
        </Box>
      </Box>

    </Container>

  );
}

export default Register;
