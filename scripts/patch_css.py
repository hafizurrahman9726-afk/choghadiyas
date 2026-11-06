with open('public/hostinger-deployment/assets/css/choghadiya-theme.css', 'r', encoding='utf-8', errors='ignore') as f:
    css = f.read()

# Make sure body background is pure white
css = css.replace('background-color: #F8FAFC;', 'background-color: #FFFFFF;')
css = css.replace('background: #F8FAFC;', 'background: #FFFFFF;')

# Fix slider-track on mobile to allow marquee animation
old_mobile_slider = """.slider-track {
    animation: none;
    overflow-x: auto;
    width: 100%;
    padding-bottom: 0.5rem;
  }"""

new_mobile_slider = """.slider-track {
    animation: marquee 35s linear infinite;
    gap: 0.85rem;
  }
  .slider-card {
    width: 175px !important;
    height: 240px !important;
    border-radius: 14px !important;
  }"""

if old_mobile_slider in css:
    css = css.replace(old_mobile_slider, new_mobile_slider)
    print('Replaced mobile slider rule!')
else:
    print('Mobile slider rule not found verbatim, appending override...')

# Append comprehensive enhancements for white theme, pagination buttons, quick pills, and touch pause
css += """

/* ============================================================
   WHITE THEME, MARQUEE & PAGINATION REFINEMENTS
   ============================================================ */
body {
  background-color: #FFFFFF !important;
  color: #0A1629;
}

.hero-supporting-text {
  font-size: 0.95rem;
  color: #64748B;
  max-width: 760px;
  margin: 0.85rem auto 1.5rem;
  line-height: 1.65;
}

.quick-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.45rem 1rem;
  background: #F8FAFC;
  border: 1px solid #CBD5E1;
  border-radius: 9999px;
  font-size: 0.85rem;
  font-weight: 600;
  color: #0A1629;
  text-decoration: none;
  transition: all 0.2s ease;
}

.quick-pill:hover {
  background: #FF7000;
  border-color: #FF7000;
  color: #FFFFFF;
  transform: translateY(-1px);
}

.slider-track.is-paused {
  animation-play-state: paused !important;
}

.pagination-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.4rem;
  margin-top: 2.5rem;
}

.page-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 38px;
  height: 38px;
  padding: 0 0.75rem;
  font-size: 0.9rem;
  font-weight: 600;
  color: #0A1629;
  background: #FFFFFF;
  border: 1px solid #CBD5E1;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.15s ease;
  user-select: none;
}

.page-btn:hover {
  background: #F8FAFC;
  border-color: #94A3B8;
  color: #FF7000;
}

.page-btn.active {
  background: #FF7000;
  border-color: #FF7000;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 2px 6px rgba(255, 112, 0, 0.3);
}

.page-btn.prev, .page-btn.next {
  padding: 0 1rem;
  font-size: 0.85rem;
}

@media (max-width: 768px) {
  .slider-track {
    animation: marquee 35s linear infinite !important;
    gap: 0.85rem !important;
  }
  .slider-card {
    width: 175px !important;
    height: 240px !important;
    border-radius: 14px !important;
  }
}
"""

with open('public/hostinger-deployment/assets/css/choghadiya-theme.css', 'w', encoding='utf-8') as f:
    f.write(css)

print('Updated choghadiya-theme.css successfully!')
