
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.9.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.9.0/firebase-analytics.js";
  
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyD5papiWcb529i5I3-gXwHPzFLW2E1GSg4",
    authDomain: "t-ui-af1c8.firebaseapp.com",
    databaseURL: "https://t-ui-af1c8-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "t-ui-af1c8",
    storageBucket: "t-ui-af1c8.firebasestorage.app",
    messagingSenderId: "1085796273980",
    appId: "1:1085796273980:web:08c1cdd09fcbc5ceebd839",
    measurementId: "G-918HXQZQXV"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  
  const analytics = getAnalytics(app);