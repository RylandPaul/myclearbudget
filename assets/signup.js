(function () {
  'use strict';

  const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  async function subscribe({ firstName = '', email, source, website = '' }) {
    const endpoint = window.MCB_SIGNUP_API_URL;
    const normalizedEmail = String(email || '').trim().toLowerCase();
    const normalizedName = String(firstName || '').trim();

    if (!endpoint || !/^https:\/\//.test(endpoint)) {
      throw new Error('Signup service is not configured');
    }
    if (!EMAIL_PATTERN.test(normalizedEmail) || normalizedEmail.length > 254) {
      throw new Error('Invalid email');
    }
    if (normalizedName.length > 100 || !['book', 'couples'].includes(source)) {
      throw new Error('Invalid signup request');
    }

    const response = await fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({
        email: normalizedEmail,
        firstName: normalizedName,
        source,
        website: String(website || '')
      })
    });

    if (!response.ok) throw new Error('Signup request failed');
    return { ok: true };
  }

  window.MyClearBudgetSignup = { subscribe };
})();
