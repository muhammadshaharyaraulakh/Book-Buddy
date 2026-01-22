// Direct raw link to a reliable JSON Gist
const API_URL = "https://gist.githubusercontent.com/arahimx/2aae39426c6d358aaabf7cdcbe32784a/raw/Pakistan%2520Cities%2520Json%2520Array";

async function getPunjabCities() {
  try {
    const response = await fetch(API_URL);
    const data = await response.json();
    
    // The JSON is structured by Province, so we just select 'Punjab'
    const punjabCities = data["Pakistan"]["Punjab"];
    
    console.log(punjabCities); 
    // Output: [{Name: "Lahore", ...}, {Name: "Faisalabad", ...}, ...]
  } catch (error) {
    console.error("Error fetching cities:", error);
  }
}

getPunjabCities();