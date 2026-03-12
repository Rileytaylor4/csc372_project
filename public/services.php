<?php
/*
Name: Riley C. Taylor
Date: 2026-03-08
FILE: services.php

Images that will be used:
- oil-change.jpg
- brake-change.jpg
- tune-up.jpg
- detailing.jpeg
- custom-parts.jpg
- tire-patching.jpg
- rear-end.jpg
- suspension.jpg

Description:
This file displays the services offered with a description and image.
It has been updated to use PHP objects for Assignment 6.

AI was used to help organize the class structure and object output.
*/

/*
Class: Service
Purpose: Represents one automotive service offered by Forge & Fender.
*/
class Service
{
  public string $title;
  public string $image;
  public string $altText;
  public string $description;
  public array $details;
  public float $startingPrice;
  public bool $mobileService;

  /*
  Constructor: creates a new service object with all required values
  */
  public function __construct(
    string $title,
    string $image,
    string $altText,
    string $description,
    array $details,
    float $startingPrice,
    bool $mobileService
  ) {
    $this->title = $title;
    $this->image = $image;
    $this->altText = $altText;
    $this->description = $description;
    $this->details = $details;
    $this->startingPrice = $startingPrice;
    $this->mobileService = $mobileService;
  }

  /*
  Method: returns the starting price in currency format
  */
  public function getFormattedPrice(): string
  {
    return '$' . number_format($this->startingPrice, 2);
  }

  /*
  Method: returns whether the service is available as a mobile service
  */
  public function getMobileLabel(): string
  {
    return $this->mobileService ? 'Mobile Service Available' : 'Shop Referral May Be Needed';
  }
}

/* Service objects */
$services = [
  new Service(
    "Oil Change",
    "oil-change.jpg",
    "Oil change service",
    "Fresh oil is the simplest way to extend engine life and keep everything running smooth. We’ll replace your oil,
    install a new filter, and verify the correct oil type and capacity for your specific vehicle.",
    [
      "Oil types: conventional, synthetic blend, full synthetic, and high-mileage.",
      "Common viscosities include 0W-20, 5W-20, 5W-30, 0W-30, and 10W-30 (vehicle-dependent).",
      "Includes: drain + refill, new filter, fluid level check, and basic leak/condition check.",
      "Recommended intervals vary, but many vehicles fall between 3,000–7,500 miles depending on oil type and driving conditions."
    ],
    69.99,
    true
  ),
  new Service(
    "Brakes",
    "brake-change.jpg",
    "Brake service",
    "Brakes should feel consistent, quiet, and confident. If you’re hearing squealing/grinding, feeling vibration,
    or noticing longer stopping distance, it’s time for an inspection.",
    [
      "Brake pad replacement (front, rear, or both) and hardware inspection.",
      "Rotor evaluation: resurface/replace recommendations based on thickness and condition.",
      "Caliper checks for sticking, uneven wear, and brake fluid leaks.",
      "Typical pad life: often 30,000–70,000 miles depending on vehicle, pad compound, and driving style."
    ],
    149.99,
    true
  ),
  new Service(
    "Tune Ups",
    "tune-up.jpg",
    "Tune up service",
    "If your car feels sluggish, idles rough, or your fuel economy has dropped, a tune-up can restore performance.
    We focus on the components that commonly impact ignition, airflow, and fuel efficiency.",
    [
      "Spark plug replacement (and ignition coil evaluation if needed).",
      "Air filter and cabin filter inspection/replacement.",
      "Battery/charging system check and basic sensor/engine light pre-check (when applicable).",
      "Interval depends on your vehicle; many spark plugs are due around 60,000–100,000 miles."
    ],
    129.99,
    true
  ),
  new Service(
    "Detailing",
    "detailing.jpeg",
    "Detailing service",
    "A clean vehicle looks better, feels better, and holds value longer. Whether you need a quick refresh or a deeper clean,
    we can tailor the detail to your goals.",
    [
      "Interior: vacuum, wipe-down, plastics/leather care, and spot cleaning.",
      "Exterior: wash, decontamination (as needed), and protective finishing options.",
      "Windows, wheels, and trim cleanup for a complete look.",
      "Ideal before photos, events, seasonal changeovers, or selling/trading in."
    ],
    89.99,
    true
  ),
  new Service(
    "Custom Part Installation",
    "custom-parts.jpg",
    "Custom part installation service",
    "Upgrading your vehicle should be clean, safe, and correctly installed the first time. If you already have parts ready,
    we can install them and verify fitment and basic operation.",
    [
      "Common installs: intakes, exhaust components, lighting, suspension bolt-ons, and accessory add-ons.",
      "Hardware and mounting checks to ensure everything is secure and routed properly.",
      "Advice on parts compatibility and any extra items needed (gaskets, clamps, fluids, etc.).",
      "We’ll always communicate clearly if a job requires shop-level equipment before starting."
    ],
    119.99,
    true
  ),
  new Service(
    "Tire Patching",
    "tire-patching.jpg",
    "Tire patching service",
    "A nail or screw doesn’t always mean you need a new tire. If the puncture is in a safe repair area,
    a proper patch/plug repair can get you back on the road quickly.",
    [
      "Puncture assessment (location, size, and tire condition) to confirm it’s safe to repair.",
      "Leak check and tire pressure verification after repair.",
      "Recommendations when a tire is not repairable (sidewall damage, large puncture, or unsafe wear).",
      "Great for commuters and emergencies without a shop visit."
    ],
    39.99,
    true
  ),
  new Service(
    "Rear Ends (Differential Service)",
    "rear-end.jpg",
    "Rear end service",
    "Your rear differential (rear end) is responsible for transferring power to the wheels. Fresh gear oil helps protect
    bearings and gears, especially if you drive hard, tow, or have a performance setup.",
    [
      "Differential fluid change and inspection for leaks/contamination.",
      "Checks for abnormal noise symptoms: whining, clunking, or vibration.",
      "Service intervals vary; many vehicles benefit around 30,000–60,000 miles depending on use.",
      "Guidance on gear oil types/weights and limited-slip additive needs (vehicle-dependent)."
    ],
    99.99,
    true
  ),
  new Service(
    "Suspension",
    "suspension.jpg",
    "Suspension service",
    "If your vehicle feels bouncy, clunks over bumps, pulls to one side, or wears tires unevenly, your suspension
    may need attention. We focus on restoring ride quality, handling, and safety.",
    [
      "Inspection of common wear points: shocks/struts, control arms, ball joints, and sway bar links.",
      "Diagnosis of noises, steering feel issues, and uneven tire wear.",
      "Replacement recommendations based on condition and drivability symptoms.",
      "After suspension work, alignment may be recommended to protect tire life and handling."
    ],
    159.99,
    true
  )
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Services | Forge & Fender Mobile Auto Works</title>

  <style>
    @font-face {
      font-family: "Recoleta";
      src: url("Recoleta-Regular.woff2") format("woff2");
      font-weight: 400;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: "Recoleta";
      src: url("Recoleta-Bold.woff2") format("woff2");
      font-weight: 700;
      font-style: normal;
      font-display: swap;
    }

    :root{
      --bg: #0a0a0c;
      --text: #f4f4f6;
      --muted: rgba(244, 244, 246, 0.78);
      --card: rgba(16, 16, 20, 0.62);
      --border: rgba(255, 255, 255, 0.12);
      --border-strong: rgba(255, 255, 255, 0.18);
      --accent: rgba(255, 255, 255, 0.92);
    }

    *{ box-sizing: border-box; }
    html, body{ height: 100%; }

    body{
      margin: 0;
      color: var(--text);
      background: var(--bg);
      font-family: "Recoleta", ui-serif, Georgia, "Times New Roman", Times, serif;
      line-height: 1.55;
      overflow-x: hidden;
    }

    .starfield{
      position: fixed;
      inset: 0;
      z-index: -2;
      background:
        radial-gradient(circle at 10% 20%, rgba(255,255,255,0.9) 0 1px, transparent 1.2px),
        radial-gradient(circle at 25% 80%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
        radial-gradient(circle at 50% 40%, rgba(255,255,255,0.75) 0 1px, transparent 1.2px),
        radial-gradient(circle at 70% 15%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
        radial-gradient(circle at 85% 65%, rgba(255,255,255,0.75) 0 1px, transparent 1.2px),
        radial-gradient(circle at 15% 55%, rgba(255,255,255,0.7) 0 1px, transparent 1.2px),
        radial-gradient(circle at 60% 85%, rgba(255,255,255,0.7) 0 1px, transparent 1.2px),
        radial-gradient(circle at 90% 30%, rgba(255,255,255,0.65) 0 1px, transparent 1.2px),
        radial-gradient(circle at 40% 10%, rgba(255,255,255,0.6) 0 1px, transparent 1.2px),
        linear-gradient(180deg, #050506 0%, #0b0b10 60%, #070708 100%);
    }

    .starfield::before{
      content:"";
      position: absolute;
      inset: -40px;
      background-image:
        radial-gradient(circle, rgba(255,255,255,0.55) 0 1px, transparent 1.3px),
        radial-gradient(circle, rgba(255,255,255,0.35) 0 1px, transparent 1.3px),
        radial-gradient(circle, rgba(255,255,255,0.25) 0 1px, transparent 1.3px),
        radial-gradient(circle, rgba(255,255,255,0.18) 0 1px, transparent 1.3px);
      background-size: 120px 120px, 180px 180px, 260px 260px, 360px 360px;
      background-position: 0 0, 60px 40px, 120px 80px, 200px 140px;
      opacity: 0.6;
      animation: drift 20s linear infinite;
    }

    .starfield::after{
      content:"";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 30% 20%, transparent 0%, rgba(0,0,0,0.55) 70%, rgba(0,0,0,0.8) 100%);
    }

    @keyframes drift{
      from{ transform: translate3d(0,0,0); }
      to{ transform: translate3d(-80px, -60px, 0); }
    }

    .wrap{
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header{
      position: sticky;
      top: 0;
      backdrop-filter: blur(10px);
      background: rgba(0,0,0,0.35);
      border-bottom: 1px solid var(--border);
      z-index: 10;
    }

    .nav{
      max-width: 1100px;
      margin: 0 auto;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .brand-title{
      font-weight: 700;
      font-size: 18px;
      letter-spacing: 0.2px;
      white-space: nowrap;
    }

    nav ul{
      list-style: none;
      display: flex;
      gap: 10px;
      margin: 0;
      padding: 0;
    }

    nav a{
      text-decoration: none;
      color: var(--accent);
      padding: 10px 12px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 14px;
      transition: 160ms ease;
    }

    nav a:hover{
      background: rgba(255,255,255,0.06);
    }

    main{
      flex: 1;
      max-width: 1100px;
      margin: 0 auto;
      padding: 80px 18px 60px;
      display: flex;
      justify-content: center;
    }

    .page{
      width: 100%;
      max-width: 980px;
    }

    .hero{
      padding: 26px 24px;
      border-radius: 18px;
      background: var(--card);
      border: 1px solid var(--border);
      box-shadow: 0 12px 40px rgba(0,0,0,0.35);
      margin-bottom: 18px;
    }

    h1{
      font-size: clamp(34px, 4vw, 56px);
      margin: 0 0 10px;
      font-weight: 700;
    }

    .subtitle{
      margin: 0;
      color: var(--muted);
      font-size: 16px;
    }

    .services{
      width: 100%;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 18px;
      margin-top: 18px;
    }

    .service-card{
      border: 1px solid var(--border);
      border-radius: 18px;
      background: rgba(16, 16, 20, 0.45);
      box-shadow: 0 12px 40px rgba(0,0,0,0.28);
      overflow: hidden;
    }

    .service-card img{
      width: 100%;
      height: 210px;
      object-fit: cover;
      display: block;
    }

    .service-body{
      padding: 16px 16px 18px;
    }

    .service-title{
      margin: 0 0 8px;
      font-size: 18px;
      font-weight: 700;
    }

    .service-text{
      margin: 0 0 12px;
      color: var(--muted);
      font-size: 14.5px;
      line-height: 1.6;
    }

    .service-list{
      margin: 0;
      padding-left: 18px;
      color: var(--muted);
      font-size: 14.5px;
      line-height: 1.6;
    }

    .service-meta{
      margin: 0 0 12px;
      color: var(--muted);
      font-size: 14px;
      line-height: 1.6;
    }

    @media (max-width: 980px){
      .services{ grid-template-columns: 1fr; }
      .service-card img{ height: 220px; }
    }

    footer{
      text-align: center;
      padding: 18px;
      font-size: 13px;
      color: rgba(244,244,246,0.65);
    }
  </style>
</head>

<body>
  <div class="starfield"></div>

  <div class="wrap">
    <header>
      <div class="nav">
        <div class="brand-title">Forge &amp; Fender Mobile Auto Works</div>
        <nav>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="schedule-appointment.html">Schedule Appointment</a></li>
            <li><a href="./services.php">Services</a></li>
            <li><a href="vin-checker.html">Recall Checker</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
      <div class="page">
        <section class="hero" aria-label="Services Overview">
          <h1>Services</h1>
          <p class="subtitle">
            At-home maintenance and repairs done right in your driveway. Below are some of the most common services we provide.
          </p>
        </section>

        <section class="services" aria-label="Service List">
          <?php foreach ($services as $service): ?>
            <article class="service-card">
              <img src="<?php echo htmlspecialchars($service->image); ?>" alt="<?php echo htmlspecialchars($service->altText); ?>">
              <div class="service-body">
                <h2 class="service-title"><?php echo htmlspecialchars($service->title); ?></h2>
                <p class="service-meta">
                  Starting at <?php echo $service->getFormattedPrice(); ?> • <?php echo htmlspecialchars($service->getMobileLabel()); ?>
                </p>
                <p class="service-text"><?php echo htmlspecialchars($service->description); ?></p>
                <ul class="service-list">
                  <?php foreach ($service->details as $detail): ?>
                    <li><?php echo htmlspecialchars($detail); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </article>
          <?php endforeach; ?>
        </section>
      </div>
    </main>

    <footer>
      © <span id="year"></span> Forge &amp; Fender Mobile Auto Works
    </footer>
  </div>

  <script>
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
</body>
</html>