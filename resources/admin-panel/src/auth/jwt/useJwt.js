import useJwt from '@core/auth/jwt/useJwt'
import axios from '@axios'


const jwtOverrideConfig = {
    // Endpoints
    loginEndpoint: '/admin/api/login',
    registerEndpoint: '/admin/api/register',
    refreshEndpoint: '/admin/api/refresh-token',
    logoutEndpoint: '/admin/api/logout',

    // This will be prefixed in authorization header with token
    // e.g. Authorization: Bearer <token>
    tokenType: 'Bearer',

    // Value of this property will be used as key to store JWT token in storage
    storageTokenKeyName: 'accessToken',
    storageRefreshTokenKeyName: 'refreshToken',
}

const { jwt } = useJwt(axios, jwtOverrideConfig)
export default jwt
