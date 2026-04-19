/*
Name: Riley C. Taylor
Date: 2026-04-19
File: VinChecker.jsx
Description: VIN recall checker page using the public NHTSA API.
*/

import { useState } from "react";
import SectionTitle from "../components/SectionTitle";

function VinChecker() {
  const [vin, setVin] = useState("");
  const [vehicle, setVehicle] = useState(null);
  const [recalls, setRecalls] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  async function handleSubmit(event) {
    event.preventDefault();
    setError("");
    setVehicle(null);
    setRecalls([]);

    const cleanedVin = vin.trim().toUpperCase();

    if (cleanedVin.length !== 17) {
      setError("Please enter a valid 17-character VIN.");
      return;
    }

    setLoading(true);

    try {
      const decodeResponse = await fetch(
        `https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVinValues/${cleanedVin}?format=json`
      );
      const decodeData = await decodeResponse.json();
      const decodedVehicle = decodeData.Results[0];

      if (
        !decodedVehicle ||
        !decodedVehicle.Make ||
        !decodedVehicle.Model ||
        !decodedVehicle.ModelYear
      ) {
        setError("Unable to decode that VIN. Please check it and try again.");
        setLoading(false);
        return;
      }

      setVehicle({
        make: decodedVehicle.Make,
        model: decodedVehicle.Model,
        year: decodedVehicle.ModelYear,
      });

      const recallResponse = await fetch(
        `https://api.nhtsa.gov/recalls/recallsByVehicle?make=${encodeURIComponent(
          decodedVehicle.Make
        )}&model=${encodeURIComponent(
          decodedVehicle.Model
        )}&modelYear=${encodeURIComponent(decodedVehicle.ModelYear)}`
      );
      const recallData = await recallResponse.json();

      setRecalls(recallData.results || []);
    } catch (fetchError) {
      setError("Something went wrong while checking the VIN. Please try again.");
    }

    setLoading(false);
  }

  return (
    <main>
      <SectionTitle
        title="VIN Recall Checker"
        subtitle="Enter a 17-character VIN to decode the vehicle and check for open recalls."
      />

      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="vin"
          placeholder="Enter VIN"
          value={vin}
          onChange={(event) => setVin(event.target.value.toUpperCase())}
          maxLength="17"
        />
        <button type="submit" disabled={loading}>
          {loading ? "Checking..." : "Check VIN"}
        </button>

        {error && <p>{error}</p>}
      </form>

      {vehicle && (
        <section className="vin-results">
          <article>
            <h3>Vehicle Details</h3>
            <p><strong>Year:</strong> {vehicle.year}</p>
            <p><strong>Make:</strong> {vehicle.make}</p>
            <p><strong>Model:</strong> {vehicle.model}</p>
          </article>

          <article>
            <h3>Recall Results</h3>
            {recalls.length > 0 ? (
              recalls.map((recall, index) => (
                <div key={index} className="recall-item">
                  <p><strong>Component:</strong> {recall.Component || "N/A"}</p>
                  <p><strong>Summary:</strong> {recall.Summary || "No summary available."}</p>
                  <p><strong>Consequence:</strong> {recall.Consequence || "Not listed."}</p>
                  <p><strong>Remedy:</strong> {recall.Remedy || "Not listed."}</p>
                </div>
              ))
            ) : (
              <p>No recalls found for this vehicle.</p>
            )}
          </article>
        </section>
      )}
    </main>
  );
}

export default VinChecker;