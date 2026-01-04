--
-- PostgreSQL database dump
--

\restrict etFDGvBksYwOgGX6dINgypKuGKsHhlTdu1LwzFSM4sh9jO2hfLZ7sW1HCkv6QXg

-- Dumped from database version 16.11 (Ubuntu 16.11-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.11 (Ubuntu 16.11-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: audits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.audits (
    id bigint NOT NULL,
    user_type character varying(255),
    user_id bigint,
    event character varying(255) NOT NULL,
    auditable_type character varying(255) NOT NULL,
    auditable_id bigint NOT NULL,
    old_values text,
    new_values text,
    url text,
    ip_address inet,
    user_agent character varying(1023),
    tags character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.audits OWNER TO postgres;

--
-- Name: audits_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.audits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.audits_id_seq OWNER TO postgres;

--
-- Name: audits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.audits_id_seq OWNED BY public.audits.id;


--
-- Name: claim_notes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.claim_notes (
    id bigint NOT NULL,
    claim_no_id bigint NOT NULL,
    client_id bigint,
    from_date date,
    to_date date,
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.claim_notes OWNER TO postgres;

--
-- Name: claim_notes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.claim_notes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.claim_notes_id_seq OWNER TO postgres;

--
-- Name: claim_notes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.claim_notes_id_seq OWNED BY public.claim_notes.id;


--
-- Name: claim_registers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.claim_registers (
    id bigint NOT NULL,
    claim_no character varying(255) NOT NULL,
    file_no character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.claim_registers OWNER TO postgres;

--
-- Name: claim_registers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.claim_registers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.claim_registers_id_seq OWNER TO postgres;

--
-- Name: claim_registers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.claim_registers_id_seq OWNED BY public.claim_registers.id;


--
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255),
    mobile character varying(255),
    land_line character varying(255),
    province_id bigint,
    district_id bigint,
    city_id bigint,
    address character varying(255),
    email character varying(255),
    contact_person character varying(255),
    contact_person_contact character varying(255),
    extra text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    pan character varying(255),
    registration character varying(255),
    tax_clearence character varying(255),
    status character varying(1) DEFAULT 'Y'::character varying NOT NULL
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- Name: company_policies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_policies (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    policy_no character varying(255) NOT NULL,
    issue_date date NOT NULL,
    valid_date date NOT NULL,
    imitation_days character varying(255) NOT NULL,
    member_no character varying(255),
    issued_at character varying(255),
    f_o_agent character varying(255),
    receipt_no character varying(255),
    vat_bill_no character varying(255),
    sum_insured character varying(255),
    premium character varying(255),
    issued_by character varying(255),
    approved_by character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    nepal_ri character varying(255),
    himalayan_ri character varying(255),
    retention character varying(255),
    quota character varying(255),
    surplus_i character varying(255),
    surplus_ii character varying(255),
    auto_fac character varying(255),
    facultative character varying(255),
    co_insurance character varying(255),
    xol_i character varying(255),
    xol_ii character varying(255),
    xol_iii character varying(255),
    xol_iiii character varying(255),
    pool character varying(255),
    excess json,
    is_active character varying(1) DEFAULT 'Y'::character varying NOT NULL,
    is_current character varying(1) DEFAULT 'Y'::character varying NOT NULL,
    premium_amount character varying(255),
    insured_amount character varying(255),
    actual_issue_date date,
    colling_period character varying(255),
    policy_type character varying(255) DEFAULT 'group'::character varying NOT NULL,
    valid_date_type character varying(255),
    CONSTRAINT company_policies_policy_type_check CHECK (((policy_type)::text = ANY ((ARRAY['retail'::character varying, 'group'::character varying])::text[])))
);


ALTER TABLE public.company_policies OWNER TO postgres;

--
-- Name: COLUMN company_policies.policy_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.company_policies.policy_type IS 'retail=individual,group=company';


--
-- Name: company_policies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.company_policies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.company_policies_id_seq OWNER TO postgres;

--
-- Name: company_policies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.company_policies_id_seq OWNED BY public.company_policies.id;


--
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    id bigint NOT NULL,
    code character(2) NOT NULL,
    name character varying(80) NOT NULL,
    nicename character varying(80) NOT NULL,
    iso3 character(3),
    numcode smallint,
    phonecode integer NOT NULL,
    nationality character varying(40),
    is_default boolean DEFAULT false NOT NULL,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.countries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.countries_id_seq OWNER TO postgres;

--
-- Name: countries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.countries_id_seq OWNED BY public.countries.id;


--
-- Name: districts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.districts (
    id bigint NOT NULL,
    name character varying(50) NOT NULL,
    state_id bigint NOT NULL,
    is_default boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.districts OWNER TO postgres;

--
-- Name: districts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.districts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.districts_id_seq OWNER TO postgres;

--
-- Name: districts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.districts_id_seq OWNED BY public.districts.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: fiscal_years; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fiscal_years (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    status character varying(1) DEFAULT 'N'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.fiscal_years OWNER TO postgres;

--
-- Name: fiscal_years_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fiscal_years_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fiscal_years_id_seq OWNER TO postgres;

--
-- Name: fiscal_years_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fiscal_years_id_seq OWNED BY public.fiscal_years.id;


--
-- Name: form_permission; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.form_permission (
    id integer NOT NULL,
    formname character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    isinsert character(1) DEFAULT 'N'::bpchar NOT NULL,
    isupdate character(1) DEFAULT 'N'::bpchar NOT NULL,
    isedit character(1) DEFAULT 'N'::bpchar NOT NULL,
    isdelete character(1) DEFAULT 'N'::bpchar NOT NULL,
    usertypeid integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.form_permission OWNER TO postgres;

--
-- Name: form_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.form_permission_id_seq OWNER TO postgres;

--
-- Name: form_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.form_permission_id_seq OWNED BY public.form_permission.id;


--
-- Name: group_headings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.group_headings (
    id bigint NOT NULL,
    group_id bigint NOT NULL,
    heading_id bigint NOT NULL,
    is_employee character varying(1) DEFAULT 'N'::character varying NOT NULL,
    is_spouse character varying(1) DEFAULT 'N'::character varying NOT NULL,
    is_child character varying(1) DEFAULT 'N'::character varying NOT NULL,
    is_parent character varying(1) DEFAULT 'N'::character varying NOT NULL,
    amount character varying(255) NOT NULL,
    is_spouse_amount character varying(255),
    is_child_amount character varying(255),
    is_parent_amount character varying(255),
    exclusive json,
    rules json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    imitation_days character varying(255) DEFAULT '0'::character varying NOT NULL,
    limit_type character varying(255),
    "limit" character varying(255)
);


ALTER TABLE public.group_headings OWNER TO postgres;

--
-- Name: COLUMN group_headings.limit_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.group_headings.limit_type IS 'limit check for retail';


--
-- Name: group_headings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.group_headings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.group_headings_id_seq OWNER TO postgres;

--
-- Name: group_headings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.group_headings_id_seq OWNED BY public.group_headings.id;


--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groups (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255),
    status character varying(1) DEFAULT 'Y'::character varying NOT NULL,
    insurance_amount character varying(255),
    is_amount_different character varying(255) DEFAULT 'N'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    policy_id bigint,
    is_imitation_days_different character(1) DEFAULT 'N'::bpchar NOT NULL
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.groups_id_seq OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.groups_id_seq OWNED BY public.groups.id;


--
-- Name: insurance_claim_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.insurance_claim_logs (
    id bigint NOT NULL,
    insurance_claim_id bigint NOT NULL,
    audit_id bigint,
    type character varying(255),
    remarks text,
    description json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    previous_status character varying(255),
    new_status character varying(255)
);


ALTER TABLE public.insurance_claim_logs OWNER TO postgres;

--
-- Name: insurance_claim_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.insurance_claim_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.insurance_claim_logs_id_seq OWNER TO postgres;

--
-- Name: insurance_claim_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.insurance_claim_logs_id_seq OWNED BY public.insurance_claim_logs.id;


--
-- Name: insurance_claims; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.insurance_claims (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    heading_id bigint NOT NULL,
    group_id bigint,
    sub_heading_id bigint NOT NULL,
    relative_id bigint,
    claim_for character varying(255) DEFAULT 'self'::character varying NOT NULL,
    document_type character varying(255) NOT NULL,
    bill_file_name character varying(255) NOT NULL,
    bill_file_size character varying(255),
    file_path character varying(255) NOT NULL,
    document_date date,
    remark text,
    bill_amount character varying(255),
    clinical_facility_name character varying(255) NOT NULL,
    diagnosis_treatment character varying(255) NOT NULL,
    clam_type character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    register_no bigint,
    scrutiny_id bigint,
    status character varying(255),
    claim_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    submission_count integer DEFAULT 1 NOT NULL,
    is_hold character varying(255) DEFAULT 'N'::character varying NOT NULL,
    CONSTRAINT insurance_claims_claim_for_check CHECK (((claim_for)::text = ANY ((ARRAY['self'::character varying, 'other'::character varying])::text[]))),
    CONSTRAINT insurance_claims_clam_type_check CHECK (((clam_type)::text = ANY ((ARRAY['claim'::character varying, 'draft'::character varying])::text[]))),
    CONSTRAINT insurance_claims_document_type_check CHECK (((document_type)::text = ANY ((ARRAY['bill'::character varying, 'prescription'::character varying, 'report'::character varying])::text[])))
);


ALTER TABLE public.insurance_claims OWNER TO postgres;

--
-- Name: COLUMN insurance_claims.claim_for; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.insurance_claims.claim_for IS 'self or other';


--
-- Name: COLUMN insurance_claims.document_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.insurance_claims.document_type IS 'bill or prescription or report';


--
-- Name: insurance_claims_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.insurance_claims_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.insurance_claims_id_seq OWNER TO postgres;

--
-- Name: insurance_claims_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.insurance_claims_id_seq OWNED BY public.insurance_claims.id;


--
-- Name: insurance_headings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.insurance_headings (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    status character varying(1) DEFAULT 'Y'::character varying NOT NULL,
    code character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.insurance_headings OWNER TO postgres;

--
-- Name: insurance_headings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.insurance_headings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.insurance_headings_id_seq OWNER TO postgres;

--
-- Name: insurance_headings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.insurance_headings_id_seq OWNED BY public.insurance_headings.id;


--
-- Name: insurance_sub_headings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.insurance_sub_headings (
    id bigint NOT NULL,
    heading_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    status character varying(1) DEFAULT 'Y'::character varying NOT NULL,
    code character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.insurance_sub_headings OWNER TO postgres;

--
-- Name: insurance_sub_headings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.insurance_sub_headings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.insurance_sub_headings_id_seq OWNER TO postgres;

--
-- Name: insurance_sub_headings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.insurance_sub_headings_id_seq OWNED BY public.insurance_sub_headings.id;


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: member_attachments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member_attachments (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    attachment_name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.member_attachments OWNER TO postgres;

--
-- Name: member_attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.member_attachments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.member_attachments_id_seq OWNER TO postgres;

--
-- Name: member_attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.member_attachments_id_seq OWNED BY public.member_attachments.id;


--
-- Name: member_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member_details (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    citizenship_no character varying(255) NOT NULL,
    citizenship_district character varying(255) NOT NULL,
    citizenship_issued_date date NOT NULL,
    idcard_no character varying(255),
    idcard_issuing_authority character varying(255),
    idcard_issuedate date,
    idcard_valid_till date,
    income_source character varying(255),
    occupation character varying(255),
    occupation_other character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.member_details OWNER TO postgres;

--
-- Name: member_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.member_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.member_details_id_seq OWNER TO postgres;

--
-- Name: member_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.member_details_id_seq OWNED BY public.member_details.id;


--
-- Name: member_policies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member_policies (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    group_id bigint NOT NULL,
    start_date date,
    end_date date,
    status character varying(255),
    is_current character varying(1) DEFAULT 'N'::character varying NOT NULL,
    is_active character varying(1) DEFAULT 'N'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    policy_id bigint,
    individual_policy_no character varying(255),
    issue_date date,
    colling_period character varying(255),
    valid_date date,
    imitation_days character varying(255)
);


ALTER TABLE public.member_policies OWNER TO postgres;

--
-- Name: member_policies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.member_policies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.member_policies_id_seq OWNER TO postgres;

--
-- Name: member_policies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.member_policies_id_seq OWNED BY public.member_policies.id;


--
-- Name: member_relatives; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member_relatives (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    rel_name character varying(255) NOT NULL,
    rel_dob date NOT NULL,
    rel_gender character varying(255) NOT NULL,
    rel_relation character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    CONSTRAINT member_relatives_rel_relation_check CHECK (((rel_relation)::text = ANY ((ARRAY['father'::character varying, 'mother'::character varying, 'mother-in-law'::character varying, 'father-in-law'::character varying, 'spouse'::character varying, 'child1'::character varying, 'child2'::character varying])::text[])))
);


ALTER TABLE public.member_relatives OWNER TO postgres;

--
-- Name: member_relatives_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.member_relatives_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.member_relatives_id_seq OWNER TO postgres;

--
-- Name: member_relatives_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.member_relatives_id_seq OWNED BY public.member_relatives.id;


--
-- Name: members; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.members (
    id bigint NOT NULL,
    client_id bigint,
    user_id bigint,
    date_of_birth_bs character varying(255),
    date_of_birth_ad date,
    marital_status character varying(255) DEFAULT 'married'::character varying NOT NULL,
    gender character varying(255) DEFAULT 'male'::character varying NOT NULL,
    perm_province bigint,
    perm_district bigint,
    perm_city bigint,
    perm_ward_no integer,
    perm_street character varying(255),
    perm_house_no character varying(255),
    is_address_same character varying(255),
    present_province bigint,
    present_district bigint,
    present_city character varying(255),
    present_ward_no integer,
    present_street character varying(255),
    present_house_no character varying(255),
    mail_address character varying(255),
    phone_number character varying(255),
    employee_id character varying(255),
    branch character varying(255),
    designation character varying(255),
    date_of_join date,
    mobile_number bigint,
    email character varying(255),
    nationality character varying(255) NOT NULL,
    is_active character(1) DEFAULT 'Y'::bpchar NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    type character varying(255) DEFAULT 'member'::character varying NOT NULL
);


ALTER TABLE public.members OWNER TO postgres;

--
-- Name: members_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.members_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.members_id_seq OWNER TO postgres;

--
-- Name: members_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.members_id_seq OWNED BY public.members.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: module_permission; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.module_permission (
    id integer NOT NULL,
    modulesid integer NOT NULL,
    usertypeid integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.module_permission OWNER TO postgres;

--
-- Name: module_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.module_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.module_permission_id_seq OWNER TO postgres;

--
-- Name: module_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.module_permission_id_seq OWNED BY public.module_permission.id;


--
-- Name: modules; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.modules (
    id integer NOT NULL,
    modulename character varying(255) NOT NULL,
    url character varying(255),
    icon character varying(255),
    orderby integer,
    parentmoduleid integer DEFAULT 0 NOT NULL,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.modules OWNER TO postgres;

--
-- Name: modules_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.modules_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.modules_id_seq OWNER TO postgres;

--
-- Name: modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.modules_id_seq OWNED BY public.modules.id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id bigint NOT NULL,
    notification_date date,
    message text NOT NULL,
    type character varying(255) NOT NULL,
    redirect_url character varying(255),
    user_id bigint,
    is_seen character(1) DEFAULT 'N'::bpchar NOT NULL,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notifications_id_seq OWNER TO postgres;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: premium_calculations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.premium_calculations (
    id bigint NOT NULL,
    base_rate character varying(255) NOT NULL,
    dependent_factor character varying(255) NOT NULL,
    age_factor character varying(255) NOT NULL,
    period_factor character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.premium_calculations OWNER TO postgres;

--
-- Name: premium_calculations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.premium_calculations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.premium_calculations_id_seq OWNER TO postgres;

--
-- Name: premium_calculations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.premium_calculations_id_seq OWNED BY public.premium_calculations.id;


--
-- Name: scrunities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.scrunities (
    id bigint NOT NULL,
    claim_no_id bigint NOT NULL,
    member_id bigint NOT NULL,
    member_policy_id bigint NOT NULL,
    relative_id bigint,
    status character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.scrunities OWNER TO postgres;

--
-- Name: scrunities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.scrunities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.scrunities_id_seq OWNER TO postgres;

--
-- Name: scrunities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.scrunities_id_seq OWNED BY public.scrunities.id;


--
-- Name: scrunity_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.scrunity_details (
    id bigint NOT NULL,
    scrunity_id bigint NOT NULL,
    group_heading_id bigint NOT NULL,
    heading_id bigint NOT NULL,
    bill_amount character varying(255) NOT NULL,
    approved_amount character varying(255) NOT NULL,
    deduct_amount character varying(255),
    bill_no character varying(255) NOT NULL,
    file character varying(255),
    remarks text,
    extra json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint
);


ALTER TABLE public.scrunity_details OWNER TO postgres;

--
-- Name: scrunity_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.scrunity_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.scrunity_details_id_seq OWNER TO postgres;

--
-- Name: scrunity_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.scrunity_details_id_seq OWNED BY public.scrunity_details.id;


--
-- Name: settlements; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settlements (
    id bigint NOT NULL,
    member_id bigint NOT NULL,
    group_heading_id bigint NOT NULL,
    settle_amount character varying(255) NOT NULL,
    actual_amount character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.settlements OWNER TO postgres;

--
-- Name: settlements_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settlements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.settlements_id_seq OWNER TO postgres;

--
-- Name: settlements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settlements_id_seq OWNED BY public.settlements.id;


--
-- Name: states; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.states (
    id bigint NOT NULL,
    name character varying(50) NOT NULL,
    country_id integer NOT NULL,
    is_default boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.states OWNER TO postgres;

--
-- Name: states_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.states_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.states_id_seq OWNER TO postgres;

--
-- Name: states_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.states_id_seq OWNED BY public.states.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    fname character varying(255) NOT NULL,
    mname character varying(255),
    lname character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    mobilenumber character varying(255),
    countrycode character varying(255) DEFAULT '977'::character varying NOT NULL,
    usertype bigint NOT NULL,
    profile_pic character varying(255),
    last_login timestamp(0) without time zone,
    default_password character varying(255),
    is_active character(1) DEFAULT 'Y'::bpchar NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: usertype; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usertype (
    id bigint NOT NULL,
    typename character varying(255) NOT NULL,
    rolecode character varying(255),
    redirect_url character varying(255),
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.usertype OWNER TO postgres;

--
-- Name: usertype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usertype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usertype_id_seq OWNER TO postgres;

--
-- Name: usertype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usertype_id_seq OWNED BY public.usertype.id;


--
-- Name: vdcmcpts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vdcmcpts (
    id bigint NOT NULL,
    name character varying(90) NOT NULL,
    district_id bigint,
    state_id bigint,
    is_default boolean DEFAULT false NOT NULL,
    created_by bigint,
    updated_by bigint,
    organization_id bigint,
    sub_organization_id bigint,
    archived_by bigint,
    archived_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.vdcmcpts OWNER TO postgres;

--
-- Name: vdcmcpts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vdcmcpts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vdcmcpts_id_seq OWNER TO postgres;

--
-- Name: vdcmcpts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vdcmcpts_id_seq OWNED BY public.vdcmcpts.id;


--
-- Name: audits id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audits ALTER COLUMN id SET DEFAULT nextval('public.audits_id_seq'::regclass);


--
-- Name: claim_notes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_notes ALTER COLUMN id SET DEFAULT nextval('public.claim_notes_id_seq'::regclass);


--
-- Name: claim_registers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_registers ALTER COLUMN id SET DEFAULT nextval('public.claim_registers_id_seq'::regclass);


--
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- Name: company_policies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_policies ALTER COLUMN id SET DEFAULT nextval('public.company_policies_id_seq'::regclass);


--
-- Name: countries id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries ALTER COLUMN id SET DEFAULT nextval('public.countries_id_seq'::regclass);


--
-- Name: districts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts ALTER COLUMN id SET DEFAULT nextval('public.districts_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: fiscal_years id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fiscal_years ALTER COLUMN id SET DEFAULT nextval('public.fiscal_years_id_seq'::regclass);


--
-- Name: form_permission id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_permission ALTER COLUMN id SET DEFAULT nextval('public.form_permission_id_seq'::regclass);


--
-- Name: group_headings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_headings ALTER COLUMN id SET DEFAULT nextval('public.group_headings_id_seq'::regclass);


--
-- Name: groups id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);


--
-- Name: insurance_claim_logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claim_logs ALTER COLUMN id SET DEFAULT nextval('public.insurance_claim_logs_id_seq'::regclass);


--
-- Name: insurance_claims id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims ALTER COLUMN id SET DEFAULT nextval('public.insurance_claims_id_seq'::regclass);


--
-- Name: insurance_headings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_headings ALTER COLUMN id SET DEFAULT nextval('public.insurance_headings_id_seq'::regclass);


--
-- Name: insurance_sub_headings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_sub_headings ALTER COLUMN id SET DEFAULT nextval('public.insurance_sub_headings_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: member_attachments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_attachments ALTER COLUMN id SET DEFAULT nextval('public.member_attachments_id_seq'::regclass);


--
-- Name: member_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_details ALTER COLUMN id SET DEFAULT nextval('public.member_details_id_seq'::regclass);


--
-- Name: member_policies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_policies ALTER COLUMN id SET DEFAULT nextval('public.member_policies_id_seq'::regclass);


--
-- Name: member_relatives id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_relatives ALTER COLUMN id SET DEFAULT nextval('public.member_relatives_id_seq'::regclass);


--
-- Name: members id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members ALTER COLUMN id SET DEFAULT nextval('public.members_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: module_permission id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.module_permission ALTER COLUMN id SET DEFAULT nextval('public.module_permission_id_seq'::regclass);


--
-- Name: modules id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modules ALTER COLUMN id SET DEFAULT nextval('public.modules_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: premium_calculations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.premium_calculations ALTER COLUMN id SET DEFAULT nextval('public.premium_calculations_id_seq'::regclass);


--
-- Name: scrunities id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities ALTER COLUMN id SET DEFAULT nextval('public.scrunities_id_seq'::regclass);


--
-- Name: scrunity_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunity_details ALTER COLUMN id SET DEFAULT nextval('public.scrunity_details_id_seq'::regclass);


--
-- Name: settlements id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settlements ALTER COLUMN id SET DEFAULT nextval('public.settlements_id_seq'::regclass);


--
-- Name: states id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.states ALTER COLUMN id SET DEFAULT nextval('public.states_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: usertype id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usertype ALTER COLUMN id SET DEFAULT nextval('public.usertype_id_seq'::regclass);


--
-- Name: vdcmcpts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vdcmcpts ALTER COLUMN id SET DEFAULT nextval('public.vdcmcpts_id_seq'::regclass);


--
-- Data for Name: audits; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audits (id, user_type, user_id, event, auditable_type, auditable_id, old_values, new_values, url, ip_address, user_agent, tags, created_at, updated_at) FROM stdin;
1	\N	\N	created	App\\Models\\Client	2	[]	{"name":"Lacy Christensen","code":"140","mobile":"Hic suscipit enim il","land_line":"Commodo incididunt q","address":"Dolor cupiditate in","email":"tubo@mailinator.com","province_id":"3","district_id":"18","city_id":"284","contact_person":"Velit minima est ill","contact_person_contact":"Vero et dolores nobi","created_by":1,"id":2}	http://127.0.0.1:8001/admin/clients	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:36:54	2025-12-13 21:36:54
2	\N	\N	created	App\\Models\\Client	3	[]	{"name":"Amaya Sexton","code":"101","mobile":"Sint beatae autem q","land_line":"Dicta eos voluptatem","address":"Voluptatem et totam","email":"bahywyrivi@mailinator.com","province_id":"5","district_id":"43","city_id":"493","contact_person":"Enim ex exercitation","contact_person_contact":"In dicta ea maiores","created_by":1,"id":3}	http://127.0.0.1:8001/admin/clients	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:37:11	2025-12-13 21:37:11
3	\N	\N	created	App\\Models\\CompanyPolicy	1	[]	{"policy_no":"Personal Secure Plus Policy","valid_date_type":"1","colling_period":"30","imitation_days":"30","nepal_ri":"0","himalayan_ri":"0","retention":"0","quota":"0","surplus_i":"0","surplus_ii":"0","auto_fac":"0","facultative":"0","co_insurance":"0","xol_i":"0","xol_ii":"0","xol_iii":"0","xol_iiii":"0","pool":"0","client_id":1,"policy_type":"retail","issue_date":"2025-12-13","valid_date":"2025-12-13","excess":"{\\"excess_type\\":\\"percentage\\",\\"excess_value\\":\\"10\\"}","created_by":1,"id":1}	http://127.0.0.1:8001/admin/retail-policy	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:39:17	2025-12-13 21:39:17
4	\N	\N	created	App\\Models\\Group	2	[]	{"insurance_amount":"30000","client_id":1,"policy_id":"1","name":"Personal Security Insurance","code":"psi12","is_amount_different":"N","is_imitation_days_different":"N","created_by":1,"id":2}	http://127.0.0.1:8001/admin/retail-groups	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:41:23	2025-12-13 21:41:23
5	\N	\N	created	App\\Models\\GroupHeading	1	[]	{"group_id":2,"heading_id":"4","is_employee":"Y","is_spouse":"N","is_child":"N","is_parent":"N","limit":"{\\"1\\":\\"30\\"}","amount":"30000","imitation_days":"30","is_spouse_amount":null,"is_child_amount":null,"is_parent_amount":null,"exclusive":"[1]","limit_type":"{\\"1\\":\\"percentage\\"}","id":1}	http://127.0.0.1:8001/admin/retail-groups	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:41:23	2025-12-13 21:41:23
6	\N	\N	created	App\\Models\\User	2	[]	{"fname":"Roshan","lname":"Dhu ngna","email":"admin@email.com","mobilenumber":"1234567890","password":"$2y$12$hUZ2DVL1TeIwTkrRXzgYxuXugW7NCfsgClVo3HKWMXuihgM.uxrSG","usertype":"2","created_by":1,"id":2}	http://127.0.0.1:8001/admin/user	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:146.0) Gecko/20100101 Firefox/146.0	\N	2025-12-13 21:52:40	2025-12-13 21:52:40
\.


--
-- Data for Name: claim_notes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.claim_notes (id, claim_no_id, client_id, from_date, to_date, status, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: claim_registers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.claim_registers (id, claim_no, file_no, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, name, code, mobile, land_line, province_id, district_id, city_id, address, email, contact_person, contact_person_contact, extra, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, pan, registration, tax_clearence, status) FROM stdin;
1	Default Client	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Y
2	Lacy Christensen	140	Hic suscipit enim il	Commodo incididunt q	3	18	284	Dolor cupiditate in	tubo@mailinator.com	Velit minima est ill	Vero et dolores nobi	\N	2025-12-13 21:36:54	2025-12-13 21:36:54	1	\N	\N	\N	\N	\N	\N	\N	\N	Y
3	Amaya Sexton	101	Sint beatae autem q	Dicta eos voluptatem	5	43	493	Voluptatem et totam	bahywyrivi@mailinator.com	Enim ex exercitation	In dicta ea maiores	\N	2025-12-13 21:37:11	2025-12-13 21:37:11	1	\N	\N	\N	\N	\N	\N	\N	\N	Y
\.


--
-- Data for Name: company_policies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.company_policies (id, client_id, policy_no, issue_date, valid_date, imitation_days, member_no, issued_at, f_o_agent, receipt_no, vat_bill_no, sum_insured, premium, issued_by, approved_by, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, nepal_ri, himalayan_ri, retention, quota, surplus_i, surplus_ii, auto_fac, facultative, co_insurance, xol_i, xol_ii, xol_iii, xol_iiii, pool, excess, is_active, is_current, premium_amount, insured_amount, actual_issue_date, colling_period, policy_type, valid_date_type) FROM stdin;
1	1	Personal Secure Plus Policy	2025-12-13	2025-12-13	30	\N	\N	\N	\N	\N	\N	\N	\N	\N	2025-12-13 21:39:17	2025-12-13 21:39:17	1	\N	\N	\N	\N	\N	0	0	0	0	0	0	0	0	0	0	0	0	0	0	{"excess_type":"percentage","excess_value":"10"}	Y	Y	\N	\N	\N	30	retail	1
\.


--
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.countries (id, code, name, nicename, iso3, numcode, phonecode, nationality, is_default, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, created_at, updated_at) FROM stdin;
1	AF	AFGHANISTAN	Afghanistan	AFG	4	93	Afghan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
2	AL	ALBANIA	Albania	ALB	8	355	Albanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
3	DZ	ALGERIA	Algeria	DZA	12	213	Algerian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
4	AS	AMERICAN SAMOA	American Samoa	ASM	16	1684	American Samoan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
5	AD	ANDORRA	Andorra	AND	20	376	Andorran	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
6	AO	ANGOLA	Angola	AGO	24	244	Angolan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
7	AI	ANGUILLA	Anguilla	AIA	660	1264	Anguillan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
8	AQ	ANTARCTICA	Antarctica	ATA	10	0	Antarctic	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
9	AG	ANTIGUA AND BARBUDA	Antigua and Barbuda	ATG	28	1268	Antiguan or Barbudan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
10	AR	ARGENTINA	Argentina	ARG	32	54	Argentine	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
11	AM	ARMENIA	Armenia	ARM	51	374	Armenian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
12	AW	ARUBA	Aruba	ABW	533	297	Aruban	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
13	AU	AUSTRALIA	Australia	AUS	36	61	Australian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
14	AT	AUSTRIA	Austria	AUT	40	43	Austrian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
15	AZ	AZERBAIJAN	Azerbaijan	AZE	31	994	Azerbaijani	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
16	BS	BAHAMAS	Bahamas	BHS	44	1242	Bahamian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
17	BH	BAHRAIN	Bahrain	BHR	48	973	Bahraini	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
18	BD	BANGLADESH	Bangladesh	BGD	50	880	Bangladeshi	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
19	BB	BARBADOS	Barbados	BRB	52	1246	Barbadian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
20	BY	BELARUS	Belarus	BLR	112	375	Belarusian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
21	BE	BELGIUM	Belgium	BEL	56	32	Belgian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
22	BZ	BELIZE	Belize	BLZ	84	501	Belizean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
23	BJ	BENIN	Benin	BEN	204	229	Beninese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
24	BM	BERMUDA	Bermuda	BMU	60	1441	Bermudian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
25	BT	BHUTAN	Bhutan	BTN	64	975	Bhutanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
26	BO	BOLIVIA	Bolivia	BOL	68	591	Bolivian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
27	BA	BOSNIA AND HERZEGOVINA	Bosnia and Herzegovina	BIH	70	387	Bosnian or Herzegovinian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
28	BW	BOTSWANA	Botswana	BWA	72	267	Motswana or Botswanan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
29	BV	BOUVET ISLAND	Bouvet Island	BVT	74	0	Bouvet Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
30	BR	BRAZIL	Brazil	BRA	76	55	Brazilian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
31	IO	BRITISH INDIAN OCEAN TERRITORY	British Indian Ocean Territory	IOT	86	246	BIOT	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
32	BN	BRUNEI DARUSSALAM	Brunei Darussalam	BRN	96	673	Bruneian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
33	BG	BULGARIA	Bulgaria	BGR	100	359	Bulgarian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
34	BF	BURKINA FASO	Burkina Faso	BFA	854	226	Burkinabe	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
35	BI	BURUNDI	Burundi	BDI	108	257	Burundian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
36	KH	CAMBODIA	Cambodia	KHM	116	855	Cambodian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
37	CM	CAMEROON	Cameroon	CMR	120	237	Cameroonian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
38	CA	CANADA	Canada	CAN	124	1	Canadian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
39	CV	CAPE VERDE	Cape Verde	CPV	132	238	Cape Verdean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
40	KY	CAYMAN ISLANDS	Cayman Islands	CYM	136	1345	Caymanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
41	CF	CENTRAL AFRICAN REPUBLIC	Central African Republic	CAF	140	236	Central African	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
42	TD	CHAD	Chad	TCD	148	235	Chadian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
43	CL	CHILE	Chile	CHL	152	56	Chilean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
44	CN	CHINA	China	CHN	156	86	Chinese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
45	CX	CHRISTMAS ISLAND	Christmas Island	CXR	162	61	Christmas Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
46	CC	COCOS ISLANDS	Cocos Islands	\N	672	0	Cocos Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
47	CO	COLOMBIA	Colombia	COL	170	57	Colombian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
48	KM	COMOROS	Comoros	COM	174	269	Comorian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
49	CG	CONGO	Congo	COG	178	242	Congolese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
50	CD	CONGO, THE DEMOCRATIC REPUBLIC OF THE	Congo, the Democratic Republic of the	COD	180	242	Congolese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
51	CK	COOK ISLANDS	Cook Islands	COK	184	682	Cook Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
52	CR	COSTA RICA	Costa Rica	CRI	188	506	Costa Rican	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
53	CI	COTE D IVOIRE	Cote D Ivoire	CIV	384	225	Ivorian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
54	HR	CROATIA	Croatia	HRV	191	385	Croatian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
55	CU	CUBA	Cuba	CUB	192	53	Cuban	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
56	CY	CYPRUS	Cyprus	CYP	196	357	Cypriot	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
57	CZ	CZECHIA	Czech Republic	CZE	203	420	Czech	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
58	DK	DENMARK	Denmark	DNK	208	45	Danish	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
59	DJ	DJIBOUTI	Djibouti	DJI	262	253	Djiboutian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
60	DM	DOMINICA	Dominica	DMA	212	1767	Dominican	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
61	DO	DOMINICAN REPUBLIC	Dominican Republic	DOM	214	1	Dominican	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
62	EC	ECUADOR	Ecuador	ECU	218	593	Ecuadorian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
63	EG	EGYPT	Egypt	EGY	818	20	Egyptian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
64	SV	EL SALVADOR	El Salvador	SLV	222	503	Salvadoran	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
65	GQ	EQUATORIAL GUINEA	Equatorial Guinea	GNQ	226	240	Equatorial Guinean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
66	ER	ERITREA	Eritrea	ERI	232	291	Eritrean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
67	EE	ESTONIA	Estonia	EST	233	372	Estonian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
68	ET	ETHIOPIA	Ethiopia	ETH	231	251	Ethiopian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
69	FK	FALKLAND ISLANDS [MALVINAS]	Falkland Islands [Malvinas]	FLK	238	500	Falkland Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
70	FO	FAROE ISLANDS	Faroe Islands	FRO	234	298	Faroese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
71	FJ	FIJI	Fiji	FJI	242	679	Fijian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
72	FI	FINLAND	Finland	FIN	246	358	Finnish	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
73	FR	FRANCE	France	FRA	250	33	French	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
74	GF	FRENCH GUIANA	French Guiana	GUF	254	594	French Guianese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
75	PF	FRENCH POLYNESIA	French Polynesia	PYF	258	689	French Polynesian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
76	TF	FRENCH SOUTHERN TERRITORIES	French Southern Territories	ATF	260	0	French	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
77	GA	GABON	Gabon	GAB	266	241	Gabonese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
78	GM	GAMBIA	Gambia	GMB	270	220	Gambian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
79	GE	GEORGIA	Georgia	GEO	268	995	Georgian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
80	DE	GERMANY	Germany	DEU	276	49	German	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
81	GH	GHANA	Ghana	GHA	288	233	Ghanaian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
82	GI	GIBRALTAR	Gibraltar	GIB	292	350	Gibraltar	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
83	GR	GREECE	Greece	GRC	300	30	Greek	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
84	GL	GREENLAND	Greenland	GRL	304	299	Greenlandic	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
85	GD	GRENADA	Grenada	GRD	308	1473	Grenadian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
86	GP	GUADELOUPE	Guadeloupe	GLP	312	590	Guadeloupean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
87	GU	GUAM	Guam	GUM	316	1671	Guamanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
88	GT	GUATEMALA	Guatemala	GTM	320	502	Guatemalan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
89	GN	GUINEA	Guinea	GIN	324	224	Guinean	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
90	GW	GUINEA-BISSAU	Guinea-Bissau	GNB	624	245	Guinea-Bissauan	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
91	GY	GUYANA	Guyana	GUY	328	592	Guyanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
92	HT	HAITI	Haiti	HTI	332	509	Haitian	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
93	HM	HEARD ISLAND AND MCDONALD ISLANDS	Heard Island and Mcdonald Islands	HMD	334	0	Heard Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:27	2025-12-13 21:34:27
94	VA	HOLY SEE [VATICAN CITY STATE]	Holy See [Vatican City State]	VAT	336	39	Vatican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
95	HN	HONDURAS	Honduras	HND	340	504	Honduran	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
96	HK	HONG KONG	Hong Kong	HKG	344	852	Hong Kong	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
97	HU	HUNGARY	Hungary	HUN	348	36	Hungarian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
98	IS	ICELAND	Iceland	ISL	352	354	Icelandic	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
99	IN	INDIA	India	IND	356	91	Indian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
100	ID	INDONESIA	Indonesia	IDN	360	62	Indonesian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
101	IR	IRAN, ISLAMIC REPUBLIC OF	Iran, Islamic Republic of	IRN	364	98	Iranian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
102	IQ	IRAQ	Iraq	IRQ	368	964	Iraqi	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
103	IE	IRELAND	Ireland	IRL	372	353	Irish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
104	IL	ISRAEL	Israel	ISR	376	972	Israeli	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
105	IT	ITALY	Italy	ITA	380	39	Italian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
106	JM	JAMAICA	Jamaica	JAM	388	1876	Jamaican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
107	JP	JAPAN	Japan	JPN	392	81	Japanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
108	JO	JORDAN	Jordan	JOR	400	962	Jordanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
109	KZ	KAZAKHSTAN	Kazakhstan	KAZ	398	7	Kazakhstani	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
110	KE	KENYA	Kenya	KEN	404	254	Kenyan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
111	KI	KIRIBATI	Kiribati	KIR	296	686	I-Kiribati	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
112	KP	KOREA, DEMOCRATIC PEOPLES REPUBLIC OF	Korea, Democratic Peoples Republic of	PRK	408	850	North Korean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
113	KR	KOREA, REPUBLIC OF	Korea, Republic of	KOR	410	82	South Korean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
114	KW	KUWAIT	Kuwait	KWT	414	965	Kuwaiti	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
115	KG	KYRGYZSTAN	Kyrgyzstan	KGZ	417	996	Kyrgyz	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
116	LA	LAO PEOPLES DEMOCRATIC REPUBLIC	Lao Peoples Democratic Republic	LAO	418	856	Laotian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
117	LV	LATVIA	Latvia	LVA	428	371	Latvian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
118	LB	LEBANON	Lebanon	LBN	422	961	Lebanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
119	LS	LESOTHO	Lesotho	LSO	426	266	Basotho	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
120	LR	LIBERIA	Liberia	LBR	430	231	Liberian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
121	LY	LIBYAN ARAB JAMAHIRIYA	Libyan Arab Jamahiriya	LBY	434	218	Libyan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
122	LI	LIECHTENSTEIN	Liechtenstein	LIE	438	423	Liechtensteiner	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
123	LT	LITHUANIA	Lithuania	LTU	440	370	Lithuanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
124	LU	LUXEMBOURG	Luxembourg	LUX	442	352	Luxembourgish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
125	MO	MACAO	Macao	MAC	446	853	Macau	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
126	MK	NORTH MACEDONIA	North Macedonia	MKD	807	389	Macedonian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
127	MG	MADAGASCAR	Madagascar	MDG	450	261	Malagasy	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
128	MW	MALAWI	Malawi	MWI	454	265	Malawian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
129	MY	MALAYSIA	Malaysia	MYS	458	60	Malaysian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
130	MV	MALDIVES	Maldives	MDV	462	960	Maldivian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
131	ML	MALI	Mali	MLI	466	223	Malian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
132	MT	MALTA	Malta	MLT	470	356	Maltese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
133	MH	MARSHALL ISLANDS	Marshall Islands	MHL	584	692	Marshallese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
134	MQ	MARTINIQUE	Martinique	MTQ	474	596	Martinican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
135	MR	MAURITANIA	Mauritania	MRT	478	222	Mauritanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
136	MU	MAURITIUS	Mauritius	MUS	480	230	Mauritian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
137	YT	MAYOTTE	Mayotte	MYT	175	269	Mahoran	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
138	MX	MEXICO	Mexico	MEX	484	52	Mexican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
139	FM	MICRONESIA, FEDERATED STATES OF	Micronesia, Federated States of	FSM	583	691	Micronesian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
140	MD	MOLDOVA, REPUBLIC OF	Moldova, Republic of	MDA	498	373	Moldovan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
141	MC	MONACO	Monaco	MCO	492	377	Monegasque	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
142	MN	MONGOLIA	Mongolia	MNG	496	976	Mongolian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
143	MS	MONTSERRAT	Montserrat	MSR	500	1664	Montserratian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
144	MA	MOROCCO	Morocco	MAR	504	212	Moroccan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
145	MZ	MOZAMBIQUE	Mozambique	MOZ	508	258	Mozambican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
146	MM	MYANMAR	Myanmar	MMR	104	95	Burmese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
147	NA	NAMIBIA	Namibia	NAM	516	264	Namibian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
148	NR	NAURU	Nauru	NRU	520	674	Nauruan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
149	NP	NEPAL	Nepal	NPL	524	977	Nepali	t	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
150	NL	NETHERLANDS	Netherlands	NLD	528	31	Dutch	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
151	AN	NETHERLANDS ANTILLES	Netherlands Antilles	ANT	530	599	Dutch	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
152	NC	NEW CALEDONIA	New Caledonia	NCL	540	687	New Caledonian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
153	NZ	NEW ZEALAND	New Zealand	NZL	554	64	New Zealander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
154	NI	NICARAGUA	Nicaragua	NIC	558	505	Nicaraguan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
155	NE	NIGER	Niger	NER	562	227	Nigerien	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
156	NG	NIGERIA	Nigeria	NGA	566	234	Nigerian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
157	NU	NIUE	Niue	NIU	570	683	Niuean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
158	NF	NORFOLK ISLAND	Norfolk Island	NFK	574	672	Norfolk Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
159	MP	NORTHERN MARIANA ISLANDS	Northern Mariana Islands	MNP	580	1670	Northern Mariana Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
160	NO	NORWAY	Norway	NOR	578	47	Norwegian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
161	OM	OMAN	Oman	OMN	512	968	Omani	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
162	PK	PAKISTAN	Pakistan	PAK	586	92	Pakistani	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
163	PW	PALAU	Palau	PLW	585	680	Palauan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
164	PS	PALESTINIAN TERRITORY, OCCUPIED	Palestinian Territory, Occupied	PLS	970	0	Palestinian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
165	PA	PANAMA	Panama	PAN	591	507	Panamanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
166	PG	PAPUA NEW GUINEA	Papua New Guinea	PNG	598	675	Papua New Guinean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
167	PY	PARAGUAY	Paraguay	PRY	600	595	Paraguayan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
168	PE	PERU	Peru	PER	604	51	Peruvian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
169	PH	PHILIPPINES	Philippines	PHL	608	63	Filipino	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
170	PN	PITCAIRN	Pitcairn	PCN	612	0	Pitcairn Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
171	PL	POLAND	Poland	POL	616	48	Polish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
172	PT	PORTUGAL	Portugal	PRT	620	351	Portuguese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
173	PR	PUERTO RICO	Puerto Rico	PRI	630	1787	Puerto Rican	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
174	QA	QATAR	Qatar	QAT	634	974	Qatari	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
175	RE	REUNION	Reunion	REU	638	262	Réunionese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
176	RO	ROMANIA	Romania	ROU	642	40	Romanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
177	RU	RUSSIAN FEDERATION	Russian Federation	RUS	643	7	Russian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
178	RW	RWANDA	Rwanda	RWA	646	250	Rwandan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
179	SH	SAINT HELENA	Saint Helena	SHN	654	290	Saint Helenian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
180	KN	SAINT KITTS AND NEVIS	Saint Kitts and Nevis	KNA	659	1869	Kittitian/Nevisian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
181	LC	SAINT LUCIA	Saint Lucia	LCA	662	1758	Saint Lucian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
182	PM	SAINT PIERRE AND MIQUELON	Saint Pierre and Miquelon	SPM	666	508	Saint-Pierrais/Miquelonnais	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
183	VC	SAINT VINCENT AND THE GRENADINES	Saint Vincent and the Grenadines	VCT	670	1784	Vincentian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
184	WS	SAMOA	Samoa	WSM	882	684	Samoan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
185	SM	SAN MARINO	San Marino	SMR	674	378	Sammarinese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
186	ST	SAO TOME AND PRINCIPE	Sao Tome and Principe	STP	678	239	Sao Tomean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
187	SA	SAUDI ARABIA	Saudi Arabia	SAU	682	966	Saudi Arabian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
188	SN	SENEGAL	Senegal	SEN	686	221	Senegalese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
189	RS	SERBIA	Serbia	SRB	688	381	Serbian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
190	SC	SEYCHELLES	Seychelles	SYC	690	248	Seychellois	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
191	SL	SIERRA LEONE	Sierra Leone	SLE	694	232	Sierra Leonean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
192	SG	SINGAPORE	Singapore	SGP	702	65	Singaporean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
193	SK	SLOVAKIA	Slovakia	SVK	703	421	Slovak	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
194	SI	SLOVENIA	Slovenia	SVN	705	386	Slovene	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
195	SB	SOLOMON ISLANDS	Solomon Islands	SLB	90	677	Solomon Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
196	SO	SOMALIA	Somalia	SOM	706	252	Somali	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
197	ZA	SOUTH AFRICA	South Africa	ZAF	710	27	South African	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
198	GS	SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS	South Georgia and the South Sandwich Islands	SGS	239	0	South Georgian/South Sandwich Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
199	ES	SPAIN	Spain	ESP	724	34	Spanish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
200	LK	SRI LANKA	Sri Lanka	LKA	144	94	Sri Lankan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
201	SD	SUDAN	Sudan	SDN	736	249	Sudanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
202	SR	SURINAME	Suriname	SUR	740	597	Surinamer	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
203	SJ	SVALBARD AND JAN MAYEN	Svalbard and Jan Mayen	SJM	744	47	Svalbardian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
204	SZ	SWAZILAND	Swaziland	SWZ	748	268	Swazi	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
205	SE	SWEDEN	Sweden	SWE	752	46	Swedish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
206	CH	SWITZERLAND	Switzerland	CHE	756	41	Swiss	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
207	SY	SYRIAN ARAB REPUBLIC	Syrian Arab Republic	SYR	760	963	Syrian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
208	TW	TAIWAN, PROVINCE OF CHINA	Taiwan, Province of China	TWN	158	886	Taiwanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
209	TJ	TAJIKISTAN	Tajikistan	TJK	762	992	Tajik	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
210	TZ	TANZANIA, UNITED REPUBLIC OF	Tanzania, United Republic of	TZA	834	255	Tanzanian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
211	TH	THAILAND	Thailand	THA	764	66	Thai	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
212	TL	TIMOR-LESTE	Timor-Leste	TLS	626	670	East Timorese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
213	TG	TOGO	Togo	TGO	768	228	Togolese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
214	TK	TOKELAU	Tokelau	TKL	772	690	Tokelauan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
215	TO	TONGA	Tonga	TON	776	676	Tongan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
216	TT	TRINIDAD AND TOBAGO	Trinidad and Tobago	TTO	780	1868	Trinidadian/Tobagonian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
217	TN	TUNISIA	Tunisia	TUN	788	216	Tunisian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
218	TR	TURKEY	Turkey	TUR	792	90	Turkish	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
219	TM	TURKMENISTAN	Turkmenistan	TKM	795	993	Turkmen	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
220	TC	TURKS AND CAICOS ISLANDS	Turks and Caicos Islands	TCA	796	1649	Turks and Caicos Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
221	TV	TUVALU	Tuvalu	TUV	798	688	Tuvaluan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
222	UG	UGANDA	Uganda	UGA	800	256	Ugandan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
223	UA	UKRAINE	Ukraine	UKR	804	380	Ukrainian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
224	AE	UNITED ARAB EMIRATES	United Arab Emirates	ARE	784	971	Emirati	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
225	GB	UNITED KINGDOM	United Kingdom	GBR	826	44	British	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
226	US	UNITED STATES	United States	USA	840	1	American	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
227	UM	UNITED STATES MINOR OUTLYING ISLANDS	United States Minor Outlying Islands	UMI	581	1	\N	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
228	UY	URUGUAY	Uruguay	URY	858	598	Uruguayan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
229	UZ	UZBEKISTAN	Uzbekistan	UZB	860	998	Uzbek	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
230	VU	VANUATU	Vanuatu	VUT	548	678	Ni-Vanuatu	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
231	VE	VENEZUELA	Venezuela	VEN	862	58	Venezuelan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
232	VN	VIET NAM	Viet Nam	VNM	704	84	Vietnamese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
233	VG	VIRGIN ISLANDS, BRITISH	Virgin Islands, British	VGB	92	1284	British Virgin Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
234	VI	VIRGIN ISLANDS, U.S.	Virgin Islands, U.S.	VIR	850	1340	U.S. Virgin Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
235	WF	WALLIS AND FUTUNA	Wallis and Futuna	WLF	876	681	Wallisian/Futunan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
236	EH	WESTERN SAHARA	Western Sahara	ESH	732	212	Sahrawi	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
237	YE	YEMEN	Yemen	YEM	887	967	Yemeni	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
238	ZM	ZAMBIA	Zambia	ZMB	894	260	Zambian	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
239	ZW	ZIMBABWE	Zimbabwe	ZWE	716	263	Zimbabwean	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
240	ME	MONTENEGRO	Montenegro	MNE	499	382	Montenegrin	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
241	XK	KOSOVO	Kosovo	XKX	0	383	Kosovar	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
242	AX	ALAND ISLANDS	Aland Islands	ALA	248	358	Åland Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
243	BQ	BONAIRE, SINT EUSTATIUS AND SABA	Bonaire, Sint Eustatius and Saba	BES	535	599	\N	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
244	CW	CURACAO	Curacao	CUW	531	599	Curaçaoan	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
245	GG	GUERNSEY	Guernsey	GGY	831	44	Channel Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
246	IM	ISLE OF MAN	Isle of Man	IMN	833	44	Manx	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
247	JE	JERSEY	Jersey	JEY	832	44	Channel Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
248	BL	SAINT BARTHELEMY	Saint Barthelemy	BLM	652	590	Saint Barthélemy Islander	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
249	MF	SAINT MARTIN	Saint Martin	MAF	663	590	Saint-Martinoise	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
250	SX	SINT MAARTEN	Sint Maarten	SXM	534	1	Sint Maartener	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
251	SS	SOUTH SUDAN	South Sudan	SSD	728	211	South Sudanese	f	1	1	1	1	\N	\N	2025-12-13 21:34:28	2025-12-13 21:34:28
\.


--
-- Data for Name: districts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.districts (id, name, state_id, is_default, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	TAPLEJUNG	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
2	PANCHTHAR	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
3	ILLAM	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
4	JHAPA	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
5	SANKHUWASABHA	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
6	TERHATHUM	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
7	BHOJPUR	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
8	DHANKUTA	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
9	MORANG	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
10	SUNSARI	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
11	SOLUKHUMBU	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
12	KHOTANG	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
13	OKHALDHUNGA	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
14	UDAYAPUR	1	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
15	SAPTARI	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
16	SIRAHA	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
17	DOLAKHA	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
18	RAMECHHAP	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
19	SINDHULI	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
20	DHANUSHA	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
21	MAHOTTARI	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
22	SARLAHI	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
23	RASUWA	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
24	DHADING	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
25	NUWAKOT	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
26	KATHMANDU	3	t	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
27	BHAKTAPUR	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
28	LALITPUR	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
29	KAVREPALANCHOWK	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
30	SINDHUPALCHOWK	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
31	MAKWANPUR	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
32	RAUTAHAT	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
33	BARA	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
34	PARSA	2	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
35	CHITWAN	3	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
36	GORKHA	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
37	MANANG	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
38	LAMJUNG	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
39	KASKI	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
40	TANAHUN	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
41	SYANGJA	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
42	GULMI	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
43	PALPA	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
44	ARGHAKHANCHI	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
45	NAWALPUR	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
46	RUPANDEHI	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
47	KAPILVASTU	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
48	MUSTANG	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
49	MYAGDI	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
50	BAGLUNG	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
51	PARBAT	4	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
52	RUKUM EAST	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
53	ROLPA	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
54	PYUTHAN	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
55	SALYAN	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
56	DANG	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
57	DOLPA	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
58	MUGU	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
59	JUMLA	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
60	KALIKOT	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
61	HUMLA	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
62	JAJARKOT	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
63	DAILEKH	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
64	SURKHET	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
65	BANKE	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
66	BARDIYA	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
67	BAJURA	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
68	ACHHAM	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
69	BAJHANG	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
70	DOTI	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
71	KAILALI	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
72	DARCHULA	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
73	BAITADI	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
74	DADELDHURA	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
75	KANCHANPUR	7	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
76	RUKUM WEST	6	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
77	NAWALPARASI BA.SU.PU	5	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
78	NICOBAR	8	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
79	NORTH MIDDLE ANDAMAN	8	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
80	SOUTH ANDAMAN	8	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
81	ANANTAPUR	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
82	CHITTOOR	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
83	EAST GODAVARI	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
84	ALLURI SITARAMA RAJU	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
85	ANAKAPALLI	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
86	ANNAMAYA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
87	BAPATLA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
88	ELURU	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
89	GUNTUR	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
90	KADAPA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
91	KAKINADA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
92	KONASEEMA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
93	KRISHNA	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
94	KURNOOL	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
95	MANYAM	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
96	N T RAMA RAO	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
97	NANDYAL	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
98	NELLORE	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
99	PALNADU	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
100	PRAKASAM	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
101	SRI BALAJI	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
102	SRI SATYA SAI	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
103	SRIKAKULAM	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
104	VISAKHAPATNAM	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
105	VIZIANAGARAM	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
106	WEST GODAVARI	9	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
107	ANJAW	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
108	CHANGLANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
109	DIBANG VALLEY	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
110	EAST KAMENG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
111	EAST SIANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
112	KAMLE	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
113	KRA DAADI	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
114	KURUNG KUMEY	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
115	LEPA RADA	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
116	LOHIT	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
117	LONGDING	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
118	LOWER DIBANG VALLEY	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
119	LOWER SIANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
120	LOWER SUBANSIRI	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
121	NAMSAI	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
122	PAKKE KESSANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
123	PAPUM PARE	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
124	SHI YOMI	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
125	SIANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
126	TAWANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
127	TIRAP	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
128	UPPER SIANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
129	UPPER SUBANSIRI	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
130	WEST KAMENG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
131	WEST SIANG	10	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
132	BAKSA	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
133	BARPETA	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
134	BONGAIGAON	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
135	CACHAR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
136	CHARAIDEO	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
137	CHIRANG	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
138	DARRANG	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
139	DHEMAJI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
140	DHUBRI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
141	DIBRUGARH	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
142	DIMA HASAO	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
143	GOALPARA	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
144	GOLAGHAT	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
145	HAILAKANDI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
146	JORHAT	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
147	KAMRUP METROPOLITAN	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
148	KAMRUP RURAL	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
149	KARBI ANGLONG	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
150	KARIMGANJ	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
151	KOKRAJHAR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
152	LAKHIMPUR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
153	MAJULI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
154	MORIGAON	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
155	NAGAON	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
156	NALBARI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
157	SIVASAGAR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
158	SONITPUR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
159	SOUTH SALMARA-MANKACHAR	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
160	TINSUKIA	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
161	UDALGURI	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
162	WEST KARBI ANGLONG	11	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
163	ARARIA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
164	ARWAL	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
165	AURANGABAD	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
166	BANKA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
167	BEGUSARAI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
168	BHAGALPUR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
169	BHOJPUR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
170	BUXAR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
171	DARBHANGA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
172	EAST CHAMPARAN	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
173	GAYA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
174	GOPALGANJ	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
175	JAMUI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
176	JEHANABAD	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
177	KAIMUR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
178	KATIHAR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
179	KHAGARIA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
180	KISHANGANJ	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
181	LAKHISARAI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
182	MADHEPURA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
183	MADHUBANI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
184	MUNGER	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
185	MUZAFFARPUR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
186	NALANDA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
187	NAWADA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
188	PATNA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
189	PURNIA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
190	ROHTAS	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
191	SAHARSA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
192	SAMASTIPUR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
193	SARAN	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
194	SHEIKHPURA	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
195	SHEOHAR	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
196	SITAMARHI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
197	SIWAN	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
198	SUPAUL	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
199	VAISHALI	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
200	WEST CHAMPARAN	12	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
201	CHANDIGARH	13	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
202	BALOD	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
203	BALODA BAZAR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
204	BALRAMPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
205	BASTAR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
206	BEMETARA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
207	BIJAPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
208	BILASPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
209	DANTEWADA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
210	DHAMTARI	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
211	DURG	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
212	GARIABAND	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
213	GAURELA PENDRA MARWAHI	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
214	JANJGIR CHAMPA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
215	JASHPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
216	KABIRDHAM	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
217	KANKER	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
218	KHAIRAGARH	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
219	KONDAGAON	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
220	KORBA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
221	KORIYA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
222	MAHASAMUND	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
223	MANENDRAGARH	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
224	MOHLA MANPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
225	MUNGELI	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
226	NARAYANPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
227	RAIGARH	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
228	RAIPUR	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
229	RAJNANDGAON	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
230	SAKTI	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
231	SARANGARH BILAIGARH	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
232	SUKMA	14	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
233	SURAJPUR	14	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
234	SURGUJA	14	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
235	DADRA AND NAGAR HAVELI	15	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
236	DAMAN	15	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
237	DIU	15	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
238	CENTRAL DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
239	EAST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
240	NEW DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
241	NORTH DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
242	NORTH EAST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
243	NORTH WEST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
244	SHAHDARA	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
245	SOUTH DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
246	SOUTH EAST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
247	SOUTH WEST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
248	WEST DELHI	16	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
249	NORTH GOA	17	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
250	SOUTH GOA	17	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
251	AHMEDABAD	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
252	AMRELI	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
253	ANAND	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
254	ARAVALLI	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
255	BANASKANTHA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
256	BHARUCH	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
257	BHAVNAGAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
258	BOTAD	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
259	CHHOTA UDAIPUR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
260	DAHOD	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
261	DANG	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
262	DEVBHOOMI DWARKA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
263	GANDHINAGAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
264	GIR SOMNATH	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
265	JAMNAGAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
266	JUNAGADH	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
267	KHEDA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
268	KUTCH	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
269	MAHISAGAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
270	MEHSANA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
271	MORBI	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
272	NARMADA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
273	NAVSARI	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
274	PANCHMAHAL	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
275	PATAN	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
276	PORBANDAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
277	RAJKOT	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
278	SABARKANTHA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
279	SURAT	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
280	SURENDRANAGAR	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
281	TAPI	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
282	VADODARA	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
283	VALSAD	18	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
284	AMBALA	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
285	BHIWANI	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
286	CHARKHI DADRI	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
287	FARIDABAD	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
288	FATEHABAD	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
289	GURUGRAM	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
290	HISAR	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
291	JHAJJAR	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
292	JIND	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
293	KAITHAL	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
294	KARNAL	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
295	KURUKSHETRA	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
296	MAHENDRAGARH	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
297	NUH	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
298	PALWAL	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
299	PANCHKULA	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
300	PANIPAT	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
301	REWARI	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
302	ROHTAK	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
303	SIRSA	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
304	SONIPAT	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
305	YAMUNANAGAR	19	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
306	BILASPUR	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
307	CHAMBA	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
308	HAMIRPUR	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
309	KANGRA	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
310	KINNAUR	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
311	KULLU	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
312	LAHAUL SPITI	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
313	MANDI	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
314	SHIMLA	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
315	SIRMAUR	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
316	SOLAN	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
317	UNA	20	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
318	ANANTNAG	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
319	BANDIPORA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
320	BARAMULLA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
321	BUDGAM	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
322	DODA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
323	GANDERBAL	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
324	JAMMU	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
325	KATHUA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
326	KISHTWAR	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
327	KULGAM	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
328	KUPWARA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
329	POONCH	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
330	PULWAMA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
331	RAJOURI	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
332	RAMBAN	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
333	REASI	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
334	SAMBA	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
335	SHOPIAN	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
336	SRINAGAR	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
337	UDHAMPUR	21	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
338	BOKARO	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
339	CHATRA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
340	DEOGHAR	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
341	DHANBAD	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
342	DUMKA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
343	EAST SINGHBHUM	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
344	GARHWA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
345	GIRIDIH	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
346	GODDA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
347	GUMLA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
348	HAZARIBAGH	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
349	JAMTARA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
350	KHUNTI	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
351	KODERMA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
352	LATEHAR	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
353	LOHARDAGA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
354	PAKUR	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
355	PALAMU	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
356	RAMGARH	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
357	RANCHI	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
358	SAHEBGANJ	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
359	SERAIKELA KHARSAWAN	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
360	SIMDEGA	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
361	WEST SINGHBHUM	22	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
362	BAGALKOT	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
363	BANGALORE RURAL	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
364	BANGALORE URBAN	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
365	BELGAUM	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
366	BELLARY	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
367	BIDAR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
368	CHAMARAJANAGAR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
369	CHIKKABALLAPUR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
370	CHIKKAMAGALURU	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
371	CHITRADURGA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
372	DAKSHINA KANNADA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
373	DAVANAGERE	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
374	DHARWAD	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
375	GADAG	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
376	KALABURAGI	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
377	HASSAN	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
378	HAVERI	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
379	KODAGU	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
380	KOLAR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
381	KOPPAL	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
382	MANDYA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
383	MYSORE	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
384	RAICHUR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
385	RAMANAGARA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
386	SHIMOGA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
387	TUMKUR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
388	UDUPI	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
389	UTTARA KANNADA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
390	VIJAYANAGARA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
391	VIJAYAPURA	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
392	YADGIR	23	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
393	ALAPPUZHA	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
394	ERNAKULAM	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
395	IDUKKI	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
396	KANNUR	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
397	KASARAGOD	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
398	KOLLAM	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
399	KOTTAYAM	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
400	KOZHIKODE	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
401	MALAPPURAM	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
402	PALAKKAD	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
403	PATHANAMTHITTA	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
404	THIRUVANANTHAPURAM	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
405	THRISSUR	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
406	WAYANAD	24	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
407	KARGIL	25	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
408	LEH	25	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
409	LAKSHADWEEP	26	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
410	AGAR MALWA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
411	ALIRAJPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
412	ANUPPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
413	ASHOKNAGAR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
414	BALAGHAT	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
415	BARWANI	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
416	BETUL	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
417	BHIND	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
418	BHOPAL	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
419	BURHANPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
420	CHACHAURA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
421	CHHATARPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
422	CHHINDWARA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
423	DAMOH	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
424	DATIA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
425	DEWAS	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
426	DHAR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
427	DINDORI	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
428	GUNA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
429	GWALIOR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
430	HARDA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
431	HOSHANGABAD	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
432	INDORE	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
433	JABALPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
434	JHABUA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
435	KATNI	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
436	KHANDWA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
437	KHARGONE	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
438	MAIHAR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
439	MANDLA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
440	MANDSAUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
441	MORENA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
442	NAGDA	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
443	NARSINGHPUR	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
444	NEEMUCH	27	f	2025-12-13 21:34:30	2025-12-13 21:34:30	\N	\N	\N	\N	\N	\N
445	NIWARI	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
446	PANNA	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
447	RAISEN	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
448	RAJGARH	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
449	RATLAM	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
450	REWA	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
451	SAGAR	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
452	SATNA	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
453	SEHORE	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
454	SEONI	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
455	SHAHDOL	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
456	SHAJAPUR	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
457	SHEOPUR	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
458	SHIVPURI	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
459	SIDHI	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
460	SINGRAULI	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
461	TIKAMGARH	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
462	UJJAIN	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
463	UMARIA	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
464	VIDISHA	27	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
465	AHMEDNAGAR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
466	AKOLA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
467	AMRAVATI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
468	AURANGABAD	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
469	BEED	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
470	BHANDARA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
471	BULDHANA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
472	CHANDRAPUR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
473	DHULE	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
474	GADCHIROLI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
475	GONDIA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
476	HINGOLI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
477	JALGAON	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
478	JALNA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
479	KOLHAPUR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
480	LATUR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
481	MUMBAI CITY	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
482	MUMBAI SUBURBAN	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
483	NAGPUR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
484	NANDED	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
485	NANDURBAR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
486	NASHIK	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
487	OSMANABAD	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
488	PALGHAR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
489	PARBHANI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
490	PUNE	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
491	RAIGAD	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
492	RATNAGIRI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
493	SANGLI	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
494	SATARA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
495	SINDHUDURG	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
496	SOLAPUR	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
497	THANE	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
498	WARDHA	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
499	WASHIM	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
500	YAVATMAL	28	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
501	BISHNUPUR	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
502	CHANDEL	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
503	CHURACHANDPUR	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
504	IMPHAL EAST	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
505	IMPHAL WEST	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
506	JIRIBAM	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
507	KAKCHING	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
508	KAMJONG	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
509	KANGPOKPI	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
510	NONEY	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
511	PHERZAWL	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
512	SENAPATI	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
513	TAMENGLONG	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
514	TENGNOUPAL	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
515	THOUBAL	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
516	UKHRUL	29	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
517	EAST GARO HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
518	EAST JAINTIA HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
519	EAST KHASI HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
520	MAIRANG	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
521	NORTH GARO HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
522	RI BHOI	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
523	SOUTH GARO HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
524	SOUTH WEST GARO HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
525	SOUTH WEST KHASI HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
526	WEST GARO HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
527	WEST JAINTIA HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
528	WEST KHASI HILLS	30	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
529	AIZAWL	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
530	CHAMPHAI	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
531	HNAHTHIAL	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
532	KHAWZAWL	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
533	KOLASIB	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
534	LAWNGTLAI	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
535	LUNGLEI	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
536	MAMIT	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
537	SAIHA	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
538	SAITUAL	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
539	SERCHHIP	31	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
540	CHUMUKEDIMA	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
541	DIMAPUR	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
542	KIPHIRE	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
543	KOHIMA	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
544	LONGLENG	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
545	MOKOKCHUNG	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
546	MON	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
547	NIULAND	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
548	NOKLAK	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
549	PEREN	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
550	PHEK	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
551	SHAMATOR	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
552	TSEMINYU	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
553	TUENSANG	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
554	WOKHA	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
555	ZUNHEBOTO	32	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
556	ANGUL	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
557	BALANGIR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
558	BALASORE	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
559	BARGARH	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
560	BHADRAK	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
561	BOUDH	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
562	CUTTACK	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
563	DEBAGARH	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
564	DHENKANAL	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
565	GAJAPATI	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
566	GANJAM	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
567	JAGATSINGHPUR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
568	JAJPUR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
569	JHARSUGUDA	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
570	KALAHANDI	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
571	KANDHAMAL	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
572	KENDRAPARA	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
573	KENDUJHAR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
574	KHORDHA	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
575	KORAPUT	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
576	MALKANGIRI	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
577	MAYURBHANJ	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
578	NABARANGPUR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
579	NAYAGARH	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
580	NUAPADA	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
581	PURI	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
582	RAYAGADA	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
583	SAMBALPUR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
584	SUBARNAPUR	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
585	SUNDERGARH	33	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
586	KARAIKAL	34	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
587	MAHE	34	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
588	PUDUCHERRY	34	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
589	YANAM	34	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
590	AMRITSAR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
591	BARNALA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
592	BATHINDA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
593	FARIDKOT	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
594	FATEHGARH SAHIB	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
595	FAZILKA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
596	FIROZPUR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
597	GURDASPUR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
598	HOSHIARPUR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
599	JALANDHAR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
600	KAPURTHALA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
601	LUDHIANA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
602	MALERKOTLA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
603	MANSA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
604	MOGA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
605	MOHALI	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
606	MUKTSAR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
607	PATHANKOT	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
608	PATIALA	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
609	RUPNAGAR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
610	SANGRUR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
611	SHAHEED BHAGAT SINGH NAGAR	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
612	TARN TARAN	35	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
613	AJMER	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
614	ALWAR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
615	BANSWARA	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
616	BARAN	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
617	BARMER	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
618	BHARATPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
619	BHILWARA	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
620	BIKANER	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
621	BUNDI	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
622	CHITTORGARH	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
623	CHURU	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
624	DAUSA	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
625	DHOLPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
626	DUNGARPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
627	HANUMANGARH	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
628	JAIPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
629	JAISALMER	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
630	JALORE	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
631	JHALAWAR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
632	JHUNJHUNU	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
633	JODHPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
634	KARAULI	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
635	KOTA	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
636	NAGAUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
637	PALI	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
638	PRATAPGARH	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
639	RAJSAMAND	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
640	SAWAI MADHOPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
641	SIKAR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
642	SIROHI	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
643	SRI GANGANAGAR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
644	TONK	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
645	UDAIPUR	36	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
646	EAST SIKKIM	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
647	NORTH SIKKIM	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
648	PAKYONG	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
649	SORENG	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
650	SOUTH SIKKIM	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
651	WEST SIKKIM	37	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
652	ARIYALUR	38	f	2025-12-13 21:34:31	2025-12-13 21:34:31	\N	\N	\N	\N	\N	\N
653	CHENGALPATTU	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
654	CHENNAI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
655	COIMBATORE	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
656	CUDDALORE	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
657	DHARMAPURI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
658	DINDIGUL	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
659	ERODE	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
660	KALLAKURICHI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
661	KANCHIPURAM	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
662	KANYAKUMARI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
663	KARUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
664	KRISHNAGIRI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
665	MADURAI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
666	MAYILADUTHURAI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
667	NAGAPATTINAM	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
668	NAMAKKAL	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
669	NILGIRIS	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
670	PERAMBALUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
671	PUDUKKOTTAI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
672	RAMANATHAPURAM	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
673	RANIPET	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
674	SALEM	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
675	SIVAGANGA	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
676	TENKASI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
677	THANJAVUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
678	THENI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
679	THOOTHUKUDI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
680	TIRUCHIRAPPALLI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
681	TIRUNELVELI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
682	TIRUPATTUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
683	TIRUPPUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
684	TIRUVALLUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
685	TIRUVANNAMALAI	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
686	TIRUVARUR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
687	VELLORE	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
688	VILUPPURAM	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
689	VIRUDHUNAGAR	38	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
690	ADILABAD	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
691	BHADRADRI KOTHAGUDEM	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
692	HANAMKONDA	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
693	HYDERABAD	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
694	JAGTIAL	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
695	JANGAON	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
696	JAYASHANKAR	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
697	JOGULAMBA	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
698	KAMAREDDY	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
699	KARIMNAGAR	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
700	KHAMMAM	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
701	KOMARAM BHEEM	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
702	MAHABUBABAD	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
703	MAHBUBNAGAR	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
704	MANCHERIAL	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
705	MEDAK	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
706	MEDCHAL MALKAJGIRI	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
707	MULUGU	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
708	NAGARKURNOOL	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
709	NALGONDA	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
710	NARAYANPET	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
711	NIRMAL	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
712	NIZAMABAD	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
713	PEDDAPALLI	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
714	RAJANNA SIRCILLA	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
715	RANGA REDDY	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
716	SANGAREDDY	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
717	SIDDIPET	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
718	SURYAPET	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
719	VIKARABAD	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
720	WANAPARTHY	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
721	WARANGAL	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
722	YADADRI BHUVANAGIRI	39	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
723	DHALAI	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
724	GOMATI	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
725	KHOWAI	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
726	NORTH TRIPURA	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
727	SEPAHIJALA	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
728	SOUTH TRIPURA	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
729	UNAKOTI	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
730	WEST TRIPURA	40	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
731	AGRA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
732	ALIGARH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
733	AMBEDKAR NAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
734	AMETHI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
735	AMROHA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
736	AURAIYA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
737	AYODHYA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
738	AZAMGARH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
739	BAGHPAT	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
740	BAHRAICH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
741	BALLIA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
742	BALRAMPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
743	BANDA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
744	BARABANKI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
745	BAREILLY	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
746	BASTI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
747	BHADOHI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
748	BIJNOR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
749	BUDAUN	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
750	BULANDSHAHR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
751	CHANDAULI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
752	CHITRAKOOT	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
753	DEORIA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
754	ETAH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
755	ETAWAH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
756	FARRUKHABAD	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
757	FATEHPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
758	FIROZABAD	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
759	GAUTAM BUDDHA NAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
760	GHAZIABAD	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
761	GHAZIPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
762	GONDA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
763	GORAKHPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
764	HAMIRPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
765	HAPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
766	HARDOI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
767	HATHRAS	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
768	JALAUN	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
769	JAUNPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
770	JHANSI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
771	KANNAUJ	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
772	KANPUR DEHAT	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
773	KANPUR NAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
774	KASGANJ	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
775	KAUSHAMBI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
776	LAKHIMPUR KHERI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
777	KUSHINAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
778	LALITPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
779	LUCKNOW	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
780	MAHARAJGANJ	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
781	MAHOBA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
782	MAINPURI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
783	MATHURA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
784	MAU	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
785	MEERUT	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
786	MIRZAPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
787	MORADABAD	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
788	MUZAFFARNAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
789	PILIBHIT	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
790	PRATAPGARH	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
791	PRAYAGRAJ	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
792	RAEBARELI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
793	RAMPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
794	SAHARANPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
795	SAMBHAL	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
796	SANT KABIR NAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
797	SHAHJAHANPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
798	SHAMLI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
799	SHRAVASTI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
800	SIDDHARTHNAGAR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
801	SITAPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
802	SONBHADRA	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
803	SULTANPUR	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
804	UNNAO	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
805	VARANASI	41	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
806	ALMORA	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
807	BAGESHWAR	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
808	CHAMOLI	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
809	CHAMPAWAT	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
810	DEHRADUN	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
811	HARIDWAR	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
812	NAINITAL	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
813	PAURI	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
814	PITHORAGARH	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
815	RUDRAPRAYAG	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
816	TEHRI	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
817	UDHAM SINGH NAGAR	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
818	UTTARKASHI	42	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
819	ALIPURDUAR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
820	BANKURA	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
821	BIRBHUM	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
822	COOCH BEHAR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
823	DAKSHIN DINAJPUR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
824	DARJEELING	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
825	HOOGHLY	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
826	HOWRAH	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
827	JALPAIGURI	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
828	JHARGRAM	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
829	KALIMPONG	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
830	KOLKATA	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
831	MALDA	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
832	MURSHIDABAD	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
833	NADIA	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
834	NORTH 24 PARGANAS	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
835	PASCHIM BARDHAMAN	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
836	PASCHIM MEDINIPUR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
837	PURBA BARDHAMAN	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
838	PURBA MEDINIPUR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
839	PURULIA	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
840	SOUTH 24 PARGANAS	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
841	UTTAR DINAJPUR	43	f	2025-12-13 21:34:32	2025-12-13 21:34:32	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: fiscal_years; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fiscal_years (id, name, start_date, end_date, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: form_permission; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.form_permission (id, formname, slug, isinsert, isupdate, isedit, isdelete, usertypeid, created_at, updated_at) FROM stdin;
1	User Type	user-group	Y	Y	Y	Y	1	\N	\N
2	Users	users	Y	Y	Y	Y	1	\N	\N
3	Menu	menu	Y	Y	Y	Y	1	\N	\N
4	Insurance Group	group	Y	Y	Y	Y	1	\N	\N
5	Client	clients	Y	Y	Y	Y	1	\N	\N
6	Member	members	Y	Y	Y	Y	1	\N	\N
7	Insurance Heading	insurance_heading	Y	Y	Y	Y	1	\N	\N
8	Insurance Sub Heading	insurance_sub_heading	Y	Y	Y	Y	1	\N	\N
9	Claim Submission	claimsubmissions	Y	Y	Y	Y	1	\N	\N
10	Claim Received	claimreceived	Y	Y	Y	Y	1	\N	\N
11	Claim Policy	client_policy	Y	Y	Y	Y	1	\N	\N
12	Claim Registration	claimregistration	Y	Y	Y	Y	1	\N	\N
13	Claim Screening	claimscreening	Y	Y	Y	Y	1	\N	\N
14	Claim Scrutiny	claimscrutiny	Y	Y	Y	Y	1	\N	\N
15	Claim Verification	claimverification	Y	Y	Y	Y	1	\N	\N
16	Claim Approval	claimapproval	Y	Y	Y	Y	1	\N	\N
17	Fiscal Year	fiscal_year	Y	Y	Y	Y	1	\N	\N
18	Retail Policy	retail-policy	Y	Y	Y	Y	1	\N	\N
19	Premium	premium	Y	Y	Y	Y	1	\N	\N
\.


--
-- Data for Name: group_headings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.group_headings (id, group_id, heading_id, is_employee, is_spouse, is_child, is_parent, amount, is_spouse_amount, is_child_amount, is_parent_amount, exclusive, rules, created_at, updated_at, created_by, updated_by, imitation_days, limit_type, "limit") FROM stdin;
1	2	4	Y	N	N	N	30000	\N	\N	\N	[1]	\N	2025-12-13 21:41:23	2025-12-13 21:41:23	\N	\N	30	{"1":"percentage"}	{"1":"30"}
\.


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.groups (id, client_id, name, code, status, insurance_amount, is_amount_different, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, policy_id, is_imitation_days_different) FROM stdin;
1	1	Default Group	\N	Y	\N	N	\N	\N	\N	\N	\N	\N	\N	\N	\N	N
2	1	Personal Security Insurance	psi12	Y	30000	N	2025-12-13 21:41:23	2025-12-13 21:41:23	1	\N	\N	\N	\N	\N	1	N
\.


--
-- Data for Name: insurance_claim_logs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.insurance_claim_logs (id, insurance_claim_id, audit_id, type, remarks, description, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, previous_status, new_status) FROM stdin;
\.


--
-- Data for Name: insurance_claims; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.insurance_claims (id, member_id, heading_id, group_id, sub_heading_id, relative_id, claim_for, document_type, bill_file_name, bill_file_size, file_path, document_date, remark, bill_amount, clinical_facility_name, diagnosis_treatment, clam_type, register_no, scrutiny_id, status, claim_id, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, submission_count, is_hold) FROM stdin;
\.


--
-- Data for Name: insurance_headings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.insurance_headings (id, name, status, code, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	DOMICILARY	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	HOSPITALISATION	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
3	MATERNITY	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
4	DENTAL	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
5	OPTICAL	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: insurance_sub_headings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.insurance_sub_headings (id, heading_id, name, status, code, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	4	All kind of Dental Injury	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	5	General Eye Checkup	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
3	5	General EYE checkup and glass lens	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
4	2	IPD and Surgeries	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
5	1	OPD consultation and all kind of investigations	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
6	1	OPD Consultation, investigations, OPD Procedures and Medicines	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
7	1	OPD Consultation Only	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: member_attachments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member_attachments (id, member_id, attachment_name, file_name, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: member_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member_details (id, member_id, citizenship_no, citizenship_district, citizenship_issued_date, idcard_no, idcard_issuing_authority, idcard_issuedate, idcard_valid_till, income_source, occupation, occupation_other, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: member_policies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member_policies (id, member_id, group_id, start_date, end_date, status, is_current, is_active, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, policy_id, individual_policy_no, issue_date, colling_period, valid_date, imitation_days) FROM stdin;
\.


--
-- Data for Name: member_relatives; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member_relatives (id, member_id, rel_name, rel_dob, rel_gender, rel_relation, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: members; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.members (id, client_id, user_id, date_of_birth_bs, date_of_birth_ad, marital_status, gender, perm_province, perm_district, perm_city, perm_ward_no, perm_street, perm_house_no, is_address_same, present_province, present_district, present_city, present_ward_no, present_street, present_house_no, mail_address, phone_number, employee_id, branch, designation, date_of_join, mobile_number, email, nationality, is_active, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, type) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2013_04_05_080813_create_usertype_table	1
2	2014_10_12_000000_create_users_table	1
3	2014_10_12_100000_create_password_reset_tokens_table	1
4	2019_08_19_000000_create_failed_jobs_table	1
5	2019_12_14_000001_create_personal_access_tokens_table	1
6	2023_04_06_165240_create_modules_table	1
7	2023_04_07_052221_create_module_permission_table	1
8	2023_05_17_105639_create_countries_table	1
9	2023_05_17_124953_create_states_table	1
10	2023_05_17_124957_create_districts_table	1
11	2023_05_17_125017_create_vdcmcpts_table	1
12	2023_09_13_081158_form_permission_table	1
13	2024_02_01_071632_create_audits_table	1
14	2024_06_18_065843_create_clients_table	1
15	2024_06_18_072622_create_groups_table	1
16	2024_06_19_071627_create_members_table	1
17	2024_06_25_061418_create_member_details_table	1
18	2024_06_25_072618_create_member_attachments_table	1
19	2024_06_25_072646_create_member_relatives_table	1
20	2024_06_26_043211_create_insurance_headings_table	1
21	2024_06_26_043327_create_insurance_sub_headings_table	1
22	2024_06_28_115213_create_group_headings_table	1
23	2024_06_29_114757_create_member_policies_table	1
24	2024_07_02_091044_create_company_policies_table	1
25	2024_07_03_095203_create_fiscal_years_table	1
26	2024_07_04_084723_create_claim_registers_table	1
27	2024_07_07_084410_create_scrunities_table	1
28	2024_07_07_084419_create_scrunity_details_table	1
29	2024_07_08_011117_create_insurance_claims_table	1
30	2024_07_08_105129_create_settlements_table	1
31	2024_07_10_063106_create_insurance_claim_logs_table	1
32	2024_07_10_100052_create_claim_notes_table	1
33	2024_09_09_115850_add_ri_to_company_policies	1
34	2024_09_13_104311_change_datatype_of_relation_to_member_relatives	1
35	2024_09_24_144539_add_column_type_to_members	1
36	2024_09_27_110947_add_previous_status_to_insurance_claim_logs	1
37	2024_09_30_140737_add_is_hold_and_submission_count_to_insurance_claims	1
38	2024_10_02_164918_change_mobile_number_nullable_to_users	1
39	2024_10_06_150756_add_file_to_scrunity_details	1
40	2024_10_08_161529_add_column_policy_id_to_groups	1
41	2024_10_09_110212_add_column_pan_no_to_clients	1
42	2024_10_17_110151_add_column_is_active_to_company_policies	1
43	2024_10_17_152439_add_column_policy_id_to_member_policies	1
44	2024_10_21_134005_create_jobs_table	1
45	2024_10_23_114851_add_column_premimum_to_company_policies	1
46	2024_10_24_131908_create_notifications_table	1
47	2024_10_27_101043_add_is_active_to_members	1
48	2024_11_14_132016_add_is_imitation_days_different_to_groups	1
49	2024_11_14_132524_add_imitation_days_to_group_headings	1
50	2024_11_14_154917_add_actual_issue_date_to_company_policies	1
51	2024_11_16_122945_add_status_to_clients	1
52	2024_12_19_103848_add_column_of_client_policies_to_member_policies	1
53	2024_12_19_104202_add_column_to_company_policies	1
54	2024_12_19_110652_add_columns_to_group_headings	1
55	2024_12_24_114301_add_column_valid_date_type_to_company_policies	1
56	2024_12_31_113652_create_premium_calculations_table	1
\.


--
-- Data for Name: module_permission; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.module_permission (id, modulesid, usertypeid, created_at, updated_at) FROM stdin;
1	1	1	\N	\N
2	2	1	\N	\N
3	3	1	\N	\N
4	4	1	\N	\N
5	5	1	\N	\N
6	6	1	\N	\N
7	7	1	\N	\N
8	8	1	\N	\N
9	9	1	\N	\N
10	10	1	\N	\N
11	11	1	\N	\N
12	12	1	\N	\N
13	13	1	\N	\N
14	14	1	\N	\N
15	15	1	\N	\N
16	16	1	\N	\N
17	17	1	\N	\N
18	18	1	\N	\N
19	19	1	\N	\N
20	20	1	\N	\N
21	21	1	\N	\N
22	22	1	\N	\N
23	23	1	\N	\N
24	24	1	\N	\N
25	25	1	\N	\N
26	26	1	\N	\N
27	27	1	\N	\N
28	28	1	\N	\N
29	29	1	\N	\N
30	30	1	\N	\N
31	31	1	\N	\N
32	32	1	\N	\N
\.


--
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.modules (id, modulename, url, icon, orderby, parentmoduleid, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, created_at, updated_at) FROM stdin;
1	Dashboard	dashboard	fas fa-tachometer-alt	1	0	\N	\N	\N	\N	\N	\N	\N	\N
2	Preview	dashboard	fas fa-list	1	1	\N	\N	\N	\N	\N	\N	\N	\N
3	User Types	usertype	fa fa-user-secret	2	0	\N	\N	\N	\N	\N	\N	\N	\N
4	Users	user	fa fa-user-friends	3	0	\N	\N	\N	\N	\N	\N	\N	\N
5	Access Management	#	fas fa-users-cog	4	0	\N	\N	\N	\N	\N	\N	\N	\N
6	Menu	menu	fas fa-list	1	5	\N	\N	\N	\N	\N	\N	\N	\N
7	Permission	permission	fas fa-cogs	2	5	\N	\N	\N	\N	\N	\N	\N	\N
8	Form Permission	permission/form	fas fa-cogs	3	5	\N	\N	\N	\N	\N	\N	\N	\N
9	Client	clients	fas fa-user-tie	5	0	\N	\N	\N	\N	\N	\N	\N	\N
10	Set up	#	fas fa-cogs	6	0	\N	\N	\N	\N	\N	\N	\N	\N
11	Heading	headings	fas fa-list	1	10	\N	\N	\N	\N	\N	\N	\N	\N
12	Sub Heading	sub-headings	fas fa-list	2	10	\N	\N	\N	\N	\N	\N	\N	\N
13	Insurance Group	groups	fa fa-user-friends	8	0	\N	\N	\N	\N	\N	\N	\N	\N
14	Members	members	fas fa-user-tie	9	0	\N	\N	\N	\N	\N	\N	\N	\N
15	Claim Submission	#	fas fa-file-archive	10	0	\N	\N	\N	\N	\N	\N	\N	\N
16	Claim Intimation	claimsubmissions	fas fa-file-archive	1	15	\N	\N	\N	\N	\N	\N	\N	\N
17	Claim List	claimlist	fas fa-list	3	15	\N	\N	\N	\N	\N	\N	\N	\N
18	Claim Processing	#	fas fa-file-archive	10	0	\N	\N	\N	\N	\N	\N	\N	\N
19	Claim Registration	claimregistration	fas fa-file-archive	1	18	\N	\N	\N	\N	\N	\N	\N	\N
20	Claim Screening	claimscreening	fas fa-file-archive	2	18	\N	\N	\N	\N	\N	\N	\N	\N
21	Claim Verification	claimverification	fas fa-file-archive	3	18	\N	\N	\N	\N	\N	\N	\N	\N
22	Claim Approval	claimapproval	fas fa-file-archive	4	18	\N	\N	\N	\N	\N	\N	\N	\N
23	Fiscal Year	fiscal-years	fas fa-calendar	13	0	\N	\N	\N	\N	\N	\N	\N	\N
24	Individual	members	fas fa-list	1	14	\N	\N	\N	\N	\N	\N	\N	\N
25	Employee	member-groups	fas fa-list	2	14	\N	\N	\N	\N	\N	\N	\N	\N
26	MIS	reports	fas fa-chart-bar	14	0	\N	\N	\N	\N	\N	\N	\N	\N
27	Retail	retail-groups	fas fa-chart-bar	1	13	\N	\N	\N	\N	\N	\N	\N	\N
28	Company	groups	fas fa-chart-bar	2	13	\N	\N	\N	\N	\N	\N	\N	\N
29	Retail Policy	retail-policy	fas fa-wallet	9	0	\N	\N	\N	\N	\N	\N	\N	\N
30	Premium	premium	fas fa-wallet	15	0	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (id, notification_date, message, type, redirect_url, user_id, is_seen, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: premium_calculations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.premium_calculations (id, base_rate, dependent_factor, age_factor, period_factor, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	20	2	18	2	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: scrunities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.scrunities (id, claim_no_id, member_id, member_policy_id, relative_id, status, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: scrunity_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.scrunity_details (id, scrunity_id, group_heading_id, heading_id, bill_amount, approved_amount, deduct_amount, bill_no, file, remarks, extra, created_at, updated_at, created_by, updated_by) FROM stdin;
\.


--
-- Data for Name: settlements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.settlements (id, member_id, group_heading_id, settle_amount, actual_amount, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
\.


--
-- Data for Name: states; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.states (id, name, country_id, is_default, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	KOSHI	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
2	MADHESH	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
3	BAGMATI	149	t	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
4	GANDAKI	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
5	LUMBINI	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
6	KARNALI	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
7	SUDURPASHCHIM	149	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
8	ANDAMAN AND NICOBAR ISLANDS	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
9	ANDHRA PRADESH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
10	ARUNACHAL PRADESH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
11	ASSAM	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
12	BIHAR	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
13	CHANDIGARH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
14	CHHATTISGARH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
15	DADRA AND NAGAR HAVELI AND DAMAN AND DIU	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
16	DELHI	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
17	GOA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
18	GUJARAT	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
19	HARYANA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
20	HIMACHAL PRADESH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
21	JAMMU AND KASHMIR	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
22	JHARKHAND	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
23	KARNATAKA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
24	KERALA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
25	LADAKH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
26	LAKSHADWEEP	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
27	MADHYA PRADESH	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
28	MAHARASHTRA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
29	MANIPUR	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
30	MEGHALAYA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
31	MIZORAM	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
32	NAGALAND	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
33	ODISHA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
34	PUDUCHERRY	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
35	PUNJAB	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
36	RAJASTHAN	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
37	SIKKIM	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
38	TAMIL NADU	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
39	TELANGANA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
40	TRIPURA	99	f	2025-12-13 21:34:28	2025-12-13 21:34:28	\N	\N	\N	\N	\N	\N
41	UTTAR PRADESH	99	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
42	UTTARAKHAND	99	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
43	WEST BENGAL	99	f	2025-12-13 21:34:29	2025-12-13 21:34:29	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, fname, mname, lname, email, email_verified_at, password, mobilenumber, countrycode, usertype, profile_pic, last_login, default_password, is_active, remember_token, created_at, updated_at, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at) FROM stdin;
1	Super	\N	Admin	admin@gmail.com	\N	$2y$12$rc0cBrAR2E/kqPDcZs/7eemiOtf6n.3vOdvRNZFDn62WU2lSALtey	9842572377	977	1	\N	\N	\N	Y	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	Roshan	\N	Dhu ngna	admin@email.com	\N	$2y$12$hUZ2DVL1TeIwTkrRXzgYxuXugW7NCfsgClVo3HKWMXuihgM.uxrSG	1234567890	977	2	\N	\N	\N	Y	\N	2025-12-13 21:52:40	2025-12-13 21:52:40	1	\N	\N	\N	\N	\N
\.


--
-- Data for Name: usertype; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usertype (id, typename, rolecode, redirect_url, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, created_at, updated_at) FROM stdin;
1	Super Admin	SA	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	Member	MB	\N	\N	\N	\N	\N	\N	\N	\N	\N
3	Human Resource	HR	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: vdcmcpts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vdcmcpts (id, name, district_id, state_id, is_default, created_by, updated_by, organization_id, sub_organization_id, archived_by, archived_at, created_at, updated_at) FROM stdin;
1	AATHRAI TRIBENI RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
2	MIKWAKHOLA RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
3	SIRIJANGHA RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
4	PHAKTANGLUNG RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
5	SIDINGBA RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
6	MAIWAKHOLA RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
7	MERINGDEN RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
8	PHUNGLING MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
9	PATHIVARA YANGWARAK RURAL MUNICIPALITY	1	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
10	PHIDIM MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
11	HILIHANG RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
12	YANGWARAK RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
13	TUMBEWA RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
14	KUMMAYAK RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
15	MIKLAJUNG RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
16	FALGUNANDA RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
17	FALELUNG RURAL MUNICIPALITY	2	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
18	FAKPHOKTHUM RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
19	SURYODAYA MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
20	DEUMAI MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
21	RONG RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
22	MAI MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
23	MANGSEBUNG RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
24	CHULACHULI RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
25	SANDAKPUR RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
26	MAIJOGMAI RURAL MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
27	ILLAM MUNICIPALITY	3	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
28	KANKAI MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
29	BHADRAPUR MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
30	SHIVASATAXI MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
31	BUDDHASHANTI RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
32	HALDIBARI RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
33	BARHADASHI RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
34	GAURIGANJ RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
35	KACHANKAWAL RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
36	JHAPA RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
37	KAMAL RURAL MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
38	GAURADHAHA MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:32	2025-12-13 21:34:32
39	ARJUNDHARA MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
40	DAMAK MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
41	MECHINAGAR MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
42	BIRTAMOD MUNICIPALITY	4	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
43	SILICHONG RURAL MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
44	MADI MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
45	DHARMADEVI MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
46	SABHAPOKHARI RURAL MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
47	BHOTKHOLA RURAL MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
48	KHANDBARI MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
49	MAKALU RURAL MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
50	CHICHILA RURAL MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
51	CHAINPUR MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
52	PANCHAKHAPAN MUNICIPALITY	5	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
53	AATHRAI RURAL MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
54	CHHATHAR RURAL MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
55	MYANGLUNG MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
56	LALIGURANS MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
57	MENCHAYAM RURAL MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
58	PHEDAP RURAL MUNICIPALITY	6	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
59	ARUN RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
60	AAMCHOWK RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
61	HATUWAGADHI RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
62	PAUWADUNGMA RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
63	TEMKEMAIYUNG RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
64	SALPASILICHHO RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
65	RAMPRASAD RAI RURAL MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
66	SHADANANDA MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
67	BHOJPUR MUNICIPALITY	7	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
68	DHANKUTA MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
69	MAHALAXMI MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
70	PAKHRIBAS MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
71	CHHATHAR JORPATI RURAL MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
72	SANGURIGADHI RURAL MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
73	SHAHIDBHUMI RURAL MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
74	CHAUBISE RURAL MUNICIPALITY	8	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
75	RANGELI MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
76	JAHADA RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
77	KATAHARI RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
78	GRAMTHAN RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
79	DHANPALTHAN RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
80	KERABARI RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
81	BUDHIGANGA RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
82	KANEPOKHARI RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
83	MIKLAJUNG RURAL MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
84	LETANG MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
85	SUNWARSHI MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
86	PATAHRISHANISHCHARE MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
87	BIRATNAGAR METROPOLITIAN CITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
88	URALABARI MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
89	BELBARI MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
90	SUNDARHARAICHA MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
91	RATUWAMAI MUNICIPALITY	9	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
92	DHARAN SUB-METROPOLITIAN CITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
93	GADHI RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
94	KOSHI RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
95	BARJU RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
96	HARINAGAR RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
97	DEWANGANJ RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
98	BHOKRAHA NARSING RURAL MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
99	RAMDHUNI MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
100	BARAHCHHETRA MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
101	ITAHARI SUB-METROPOLITIAN CITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
102	DUHABI MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
103	INARUWA MUNICIPALITY	10	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
104	SOTANG RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
105	SOLUDUDHAKUNDA MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
106	KHUMBUPASANGLAHMU RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
107	MAAPYA DUDHKOSHI RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
108	THULUNG DUDHKOSHI RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
109	NECHASALYAN RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
110	LIKHUPIKE RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
111	MAHAKULUNG RURAL MUNICIPALITY	11	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
112	BARAHAPOKHARI RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
113	KHOTEHANG RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
114	SAKELA RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
115	DIKTEL RUPAKOT MAJHUWAGADHI MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
116	HALESI TUWACHUNG MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
117	DIPRUNG CHUICHUMMA RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
118	JANTEDHUNGA RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
119	KEPILASAGADHI RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
120	RAWA BESI RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
121	AINSELUKHARK RURAL MUNICIPALITY	12	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
122	MOLUNG RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
123	LIKHU RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
124	SUNKOSHI RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
125	CHAMPADEVI RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
126	CHISANKHUGADHI RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
127	KHIJIDEMBA RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
128	MANEBHANJYANG RURAL MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
129	SIDDHICHARAN MUNICIPALITY	13	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
130	BELAKA MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
131	KATARI MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
132	TRIYUGA MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
133	CHAUDANDIGADHI MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
134	LIMCHUNGBUNG RURAL MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
135	UDAYAPURGADHI RURAL MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
136	RAUTAMAI RURAL MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
137	TAPLI RURAL MUNICIPALITY	14	1	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
138	KANCHANRUP MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
139	RAJBIRAJ MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
140	RUPANI RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
141	DAKNESHWORI MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
142	SAPTAKOSHI RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
143	SURUNGA MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
144	SHAMBHUNATH MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
145	BODE BARSAIN MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
146	KHADAK MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
147	MAHADEVA RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
148	BISHNUPUR RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
149	CHHINNAMASTA RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
150	BALAN BIHUL RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
151	TILATHI KOILADI RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
152	AGNISAIR KRISHNA SAVARAN RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
153	HANUMANNAGAR KANKALINI MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
154	TIRAHUT RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
155	RAJGADH RURAL MUNICIPALITY	15	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
156	LAHAN MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
157	SIRAHA MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
158	DHANGADHIMAI MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
159	KALYANPUR MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
160	KARJANHA MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
161	GOLBAZAR MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
162	SUKHIPUR MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
163	AURAHI RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
164	LAXMIPUR PATARI RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
165	BARIYARPATTI RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
166	BISHNUPUR RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
167	NAWARAJPUR RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
168	BHAGAWANPUR RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
169	ARNAMA RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
170	NARAHA RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
171	SAKHUWANANKARKATTI RURAL MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
172	MIRCHAIYA MUNICIPALITY	16	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
173	KAMALA MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
174	NAGARAIN MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
175	CHHIRESHWORNATH MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
176	SAHIDNAGAR MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
177	JANAKPURDHAM SUB-METROPOLITIAN CITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
178	HANSAPUR MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
179	SABAILA MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
180	BIDEHA MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
181	DHANUSADHAM MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
182	MITHILA MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
183	GANESHMAN CHARNATH MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
184	AAURAHI RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
185	DHANAUJI RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
186	BATESHWOR RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
187	JANAKNANDANI RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
188	LAKSHMINIYA RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
189	MUKHIYAPATTI MUSARMIYA RURAL MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
190	MITHILA BIHARI MUNICIPALITY	20	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
191	MATIHANI MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
192	LOHARPATTI MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
193	JALESWOR MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
194	BHANGAHA MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
195	BARDIBAS MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
196	AURAHI MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
197	RAMGOPALPUR MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
198	GAUSHALA MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
199	MAHOTTARI RURAL MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
200	EKDANRA RURAL MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
201	SAMSI RURAL MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
202	SONAMA RURAL MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
203	PIPRA RURAL MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
204	BALWA MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
205	MANRA SISWA MUNICIPALITY	21	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
206	BRAMHAPURI RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
207	BARAHATHAWA MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
208	HARIPUR MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
209	ISHWORPUR MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
210	MALANGAWA MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
211	LALBANDI MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
212	KABILASI MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
213	BAGMATI MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
214	HARIWAN MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
215	BALARA MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
216	HARIPURWA MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
217	GODAITA MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
218	DHANKAUL RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
219	PARSA RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
220	BISHNU RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
221	RAMNAGAR RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
222	KAUDENA RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
223	BASBARIYA RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
224	CHANDRANAGAR RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
225	CHAKRAGHATTA RURAL MUNICIPALITY	22	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
226	GUJARA MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
227	YEMUNAMAI RURAL MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
228	DURGA BHAGWATI RURAL MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
229	KATAHARIYA MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
230	MAULAPUR MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
231	MADHAV NARAYAN MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
232	GAUR MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
233	GARUDA MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
234	ISHANATH MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
235	CHANDRAPUR MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
236	DEWAHHI GONAHI MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
237	BRINDABAN MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
238	RAJPUR MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
239	RAJDEVI MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
240	GADHIMAI MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
241	PHATUWA BIJAYAPUR MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
242	BAUDHIMAI MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
243	PAROHA MUNICIPALITY	32	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
244	KOLHABI MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
245	PHETA RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
246	MAHAGADHIMAI MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
247	SIMRAUNGADH MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
248	NIJGADH MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
249	PACHARAUTA MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
250	KALAIYA SUB-METROPOLITIAN CITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
251	JITPUR SIMARA SUB-METROPOLITIAN CITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
252	ADARSHKOTWAL RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
253	BISHRAMPUR RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
254	PARWANIPUR RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
255	KARAIYAMAI RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
256	BARAGADHI RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
257	SUWARNA RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
258	PRASAUNI RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
259	DEVTAL RURAL MUNICIPALITY	33	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
260	DHOBINI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
261	PARSAGADHI MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
262	POKHARIYA MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
263	THORI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
264	CHHIPAHARMAI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
265	JIRABHAWANI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
266	JAGARNATHPUR RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
267	KALIKAMAI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
268	BINDABASINI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:33	2025-12-13 21:34:33
269	PAKAHAMAINPUR RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
270	SAKHUWAPRASAUNI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
271	PATERWASUGAULI RURAL MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
272	BIRGUNJ METROPOLITIAN CITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
273	BAHUDARAMAI MUNICIPALITY	34	2	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
274	BIGU RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
275	SAILUNG RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
276	MELUNG RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
277	BAITESHWOR RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
278	TAMAKOSHI RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
279	GAURISHANKAR RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
280	KALINCHOK RURAL MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
281	JIRI MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
282	BHIMESHWOR MUNICIPALITY	17	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
283	RAMECHHAP MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
284	LIKHU TAMAKOSHI RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
285	GOKULGANGA RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
286	MANTHALI MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
287	KHADADEVI RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
288	UMAKUNDA RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
289	DORAMBA RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
290	SUNAPATI RURAL MUNICIPALITY	18	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
291	DUDHOULI MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
292	SUNKOSHI RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
293	TINPATAN RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
294	PHIKKAL RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
295	MARIN RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
296	GOLANJOR RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
297	HARIHARPURGADHI RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
298	GHANGLEKH RURAL MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
299	KAMALAMAI MUNICIPALITY	19	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
300	AMACHODINGMO RURAL MUNICIPALITY	23	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
301	UTTARGAYA RURAL MUNICIPALITY	23	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
302	KALIKA RURAL MUNICIPALITY	23	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
303	NAUKUNDA RURAL MUNICIPALITY	23	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
304	GOSAIKUNDA RURAL MUNICIPALITY	23	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
305	KHANIYABASH RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
306	GAJURI RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
307	GALCHI RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
308	THAKRE RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
309	SIDDHALEK RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
310	JWALAMUKHI RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
311	GANGAJAMUNA RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
312	RUBI VALLEY RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
313	TRIPURA SUNDARI RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
314	NETRAWATI DABJONG RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
315	BENIGHAT RORANG RURAL MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
316	NILAKANTHA MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
317	DHUNIBESI MUNICIPALITY	24	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
318	SURYAGADHI RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
319	TARKESHWAR RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
320	PANCHAKANYA RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
321	DUPCHESHWAR RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
322	BELKOTGADHI MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
323	BIDUR MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
324	KAKANI RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
325	TADI RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
326	LIKHU RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
327	MYAGANG RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
328	SHIVAPURI RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
329	KISPANG RURAL MUNICIPALITY	25	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
330	DAKSHINKALI MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
331	GOKARNESHWOR MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
332	CHANDRAGIRI MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
333	TOKHA MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
334	KATHMANDU METROPOLITIAN CITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
335	TARAKESHWOR MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
336	KIRTIPUR MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
337	SHANKHARAPUR MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
338	NAGARJUN MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
339	KAGESHWORI MANAHORA MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
340	BUDHANILAKANTHA MUNICIPALITY	26	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
341	MADHYAPUR THIMI MUNICIPALITY	27	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
342	CHANGUNARAYAN MUNICIPALITY	27	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
343	SURYABINAYAK MUNICIPALITY	27	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
344	BHAKTAPUR MUNICIPALITY	27	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
345	LALITPUR METROPOLITIAN CITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
346	GODAWARI MUNICIPALITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
347	BAGMATI RURAL MUNICIPALITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
348	MAHALAXMI MUNICIPALITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
349	MAHANKAL RURAL MUNICIPALITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
350	KONJYOSOM RURAL MUNICIPALITY	28	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
351	PANAUTI MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
352	BANEPA MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
353	PANCHKHAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
354	NAMOBUDDHA MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
355	DHULIKHEL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
356	MANDANDEUPUR MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
357	CHAURIDEURALI RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
358	KHANIKHOLA RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
359	BETHANCHOWK RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
360	MAHABHARAT RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
361	BHUMLU RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
362	TEMAL RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
363	ROSHI RURAL MUNICIPALITY	29	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
364	MELAMCHI MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
365	BHOTEKOSHI RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
366	LISANGKHU PAKHAR RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
367	INDRAWATI RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
368	TRIPURASUNDARI RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
369	CHAUTARA SANGACHOKGADHI MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
370	PANCHPOKHARI THANGPAL RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
371	BALEFI RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
372	JUGAL RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
373	SUNKOSHI RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
374	HELAMBU RURAL MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
375	BARHABISE MUNICIPALITY	30	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
376	RAKSIRANG RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
377	BHIMPHEDI RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
378	MANAHARI RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
379	KAILASH RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
380	BAKAIYA RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
381	THAHA MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
382	HETAUDA SUB-METROPOLITIAN CITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
383	INDRASAROWAR RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
384	MAKAWANPURGADHI RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
385	BAGMATI RURAL MUNICIPALITY	31	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
386	RATNANAGAR MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
387	RAPTI MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
388	MADI MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
389	KHAIRAHANI MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
390	KALIKA MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
391	BHARATPUR METROPOLITIAN CITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
392	ICHCHHYAKAMANA RURAL MUNICIPALITY	35	3	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
393	GANDAKI RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
394	DHARCHE RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
395	AARUGHAT RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
396	AJIRKOT RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
397	PALUNGTAR MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
398	GORKHA MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
399	SIRANCHOK RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
400	BHIMSENTHAPA RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
401	CHUM NUBRI RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
402	BARPAK SULIKOT RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
403	SAHID LAKHAN RURAL MUNICIPALITY	36	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
404	CHAME RURAL MUNICIPALITY	37	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
405	NARSHON RURAL MUNICIPALITY	37	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
406	NARPA BHUMI RURAL MUNICIPALITY	37	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
407	MANANG INGSHYANG RURAL MUNICIPALITY	37	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
408	MARSYANGDI RURAL MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
409	DORDI RURAL MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
410	DUDHPOKHARI RURAL MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
411	KWHOLASOTHAR RURAL MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
412	SUNDARBAZAR MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
413	BESISHAHAR MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
414	RAINAS MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
415	MADHYANEPAL MUNICIPALITY	38	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
416	ANNAPURNA RURAL MUNICIPALITY	39	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
417	MACHHAPUCHCHHRE RURAL MUNICIPALITY	39	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
418	POKHARA METROPOLITIAN CITY	39	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
419	RUPA RURAL MUNICIPALITY	39	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
420	MADI RURAL MUNICIPALITY	39	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
421	DEVGHAT RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
422	RHISHING RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
423	BHANU MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
424	BHIMAD MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
425	MYAGDE RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
426	BYAS MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
427	ANBUKHAIRENI RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
428	BANDIPUR RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
429	SHUKLAGANDAKI MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
430	GHIRING RURAL MUNICIPALITY	40	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
431	AANDHIKHOLA RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
432	BIRUWA RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
433	WALING MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
434	CHAPAKOT MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
435	GALYANG MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
436	BHIRKOT MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
437	PUTALIBAZAR MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
438	ARJUNCHAUPARI RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
439	KALIGANDAGI RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
440	PHEDIKHOLA RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
441	HARINAS RURAL MUNICIPALITY	41	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
442	SUSTA RURAL MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
443	PRATAPPUR RURAL MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
444	PALHI NANDAN RURAL MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
445	BARDAGHAT MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
446	SUNWAL MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
447	RAMGRAM MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
448	SARAWAL RURAL MUNICIPALITY	45	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
449	GHARAPJHONG RURAL MUNICIPALITY	48	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
450	THASANG RURAL MUNICIPALITY	48	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
451	LOMANTHANG RURAL MUNICIPALITY	48	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
452	LO-GHEKAR DAMODARKUNDA RURAL MUNICIPALITY	48	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
453	WARAGUNG MUKTIKHSETRA RURAL MUNICIPALITY	48	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
454	BENI MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
455	DHAULAGIRI RURAL MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
456	RAGHUGANGA RURAL MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
457	MALIKA RURAL MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
458	MANGALA RURAL MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
459	ANNAPURNA RURAL MUNICIPALITY	49	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
460	TAMAN KHOLA RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
461	TARA KHOLA RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
462	KANTHEKHOLA RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
463	DHORPATAN MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
464	GALKOT MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
465	NISIKHOLA RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
466	BAGLUNG MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
467	BADIGAD RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
468	BARENG RURAL MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
469	JAIMUNI MUNICIPALITY	50	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
470	MODI RURAL MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
471	PHALEBAS MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
472	PAINYU RURAL MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
473	JALJALA RURAL MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
474	BIHADI RURAL MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
475	MAHASHILA RURAL MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
476	KUSHMA MUNICIPALITY	51	4	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
477	RESUNGA MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
478	RURU RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
479	ISMA RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
480	MADANE RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
481	MALIKA RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
482	CHATRAKOT RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
483	DHURKOT RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
484	SATYAWATI RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
485	CHANDRAKOT RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
486	KALIGANDAKI RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
487	GULMIDARBAR RURAL MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
488	MUSIKOT MUNICIPALITY	42	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
489	RAMPUR MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
490	RAINADEVI CHHAHARA RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
491	BAGNASKALI RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
492	PURBAKHOLA RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
493	RIBDIKOT RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
494	MATHAGADHI RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
495	NISDI RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
496	TINAU RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
497	RAMBHA RURAL MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
498	TANSEN MUNICIPALITY	43	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
499	PANINI RURAL MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
500	CHHATRADEV RURAL MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
501	MALARANI RURAL MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
502	BHUMEKASTHAN MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
503	SITGANGA MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
504	SANDHIKHARKA MUNICIPALITY	44	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
505	DEVDAHA MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
506	SAINAMAINA MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
507	SIDDHARTHANAGAR MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
508	TILLOTAMA MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
509	OMSATIYA RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
510	GAIDAHAWA RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
511	ROHINI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
512	SIYARI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:34	2025-12-13 21:34:34
513	KANCHAN RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
514	MAYADEVI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
515	MARCHAWARI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
516	KOTAHIMAI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
517	SAMMARIMAI RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
518	BUTWAL SUB-METROPOLITIAN CITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
519	LUMBINI SANSKRITIK MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
520	SUDHDHODHAN RURAL MUNICIPALITY	46	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
521	YASHODHARA RURAL MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
522	BIJAYANAGAR RURAL MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
523	MAYADEVI RURAL MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
524	SUDDHODHAN RURAL MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
525	BUDDHABHUMI MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
526	KAPILBASTU MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
527	SHIVARAJ MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
528	BANGANGA MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
529	KRISHNANAGAR MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
530	MAHARAJGUNJ MUNICIPALITY	47	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
531	BHUME RURAL MUNICIPALITY	52	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
532	SISNE RURAL MUNICIPALITY	52	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
533	PUTHA UTTARGANGA RURAL MUNICIPALITY	52	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
534	PARIWARTAN RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
535	MADI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
536	THAWANG RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
537	SUNCHHAHARI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
538	LUNGRI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
539	GANGADEV RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
540	TRIBENI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
541	RUNTIGADI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
542	SUNIL SMRITI RURAL MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
543	ROLPA MUNICIPALITY	53	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
544	MALLARANI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
545	JHIMRUK RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
546	GAUMUKHI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
547	AYIRABATI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
548	NAUBAHINI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
549	SWORGADWARY MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
550	PYUTHAN MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
551	SARUMARANI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
552	MANDAVI RURAL MUNICIPALITY	54	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
553	BABAI RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
554	LAMAHI MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
555	GHORAHI SUB-METROPOLITIAN CITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
556	TULSIPUR SUB-METROPOLITIAN CITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
557	BANGLACHULI RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
558	SHANTINAGAR RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
559	DANGISHARAN RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
560	RAJPUR RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
561	RAPTI RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
562	GADHAWA RURAL MUNICIPALITY	56	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
563	RAPTI SONARI RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
564	NARAINAPUR RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
565	DUDUWA RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
566	BAIJANATH RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
567	JANKI RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
568	KHAJURA RURAL MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
569	NEPALGUNJ SUB-METROPOLITIAN CITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
570	KOHALPUR MUNICIPALITY	65	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
571	BARBARDIYA MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
572	RAJAPUR MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
573	MADHUWAN MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
574	THAKURBABA MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
575	BADHAIYATAL RURAL MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
576	GERUWA RURAL MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
577	GULARIYA MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
578	BANSAGADHI MUNICIPALITY	66	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
579	MADHYABINDU MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
580	KAWASOTI MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
581	GAIDAKOT MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
582	DEVCHULI MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
583	BINAYEE TRIBENI RURAL MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
584	HUPSEKOT RURAL MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
585	BULINGTAR RURAL MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
586	BAUDEEKALI RURAL MUNICIPALITY	77	5	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
587	SIDDHA KUMAKH RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
588	KUMAKH RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
589	DARMA RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
590	BAGCHAUR MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
591	BANGAD KUPINDE MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
592	KALIMATI RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
593	TRIBENI RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
594	CHHATRESHWORI RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
595	KAPURKOT RURAL MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
596	SHARADA MUNICIPALITY	55	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
597	SHEY PHOKSUNDO RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
598	TRIPURASUNDARI MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
599	CHHARKA TANGSONG RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
600	KAIKE RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
601	JAGADULLA RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
602	MUDKECHULA RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
603	DOLPO BUDDHA RURAL MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
604	THULI BHERI MUNICIPALITY	57	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
605	CHHAYANATH RARA MUNICIPALITY	58	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
606	MUGUM KARMARONG RURAL MUNICIPALITY	58	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
607	KHATYAD RURAL MUNICIPALITY	58	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
608	SORU RURAL MUNICIPALITY	58	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
609	CHANDANNATH MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
610	HIMA RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
611	TILA RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
612	SINJA RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
613	GUTHICHAUR RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
614	TATOPANI RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
615	PATRASI RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
616	KANAKASUNDARI RURAL MUNICIPALITY	59	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
617	PALATA RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
618	RASKOT MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
619	PACHALJHARANA RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
620	KHANDACHAKRA MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
621	SANNI TRIBENI RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
622	NARAHARINATH RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
623	MAHAWAI RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
624	SUBHA KALIKA RURAL MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
625	TILAGUFA MUNICIPALITY	60	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
626	TANJAKOT RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
627	SIMKOT RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
628	NAMKHA RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
629	CHANKHELI RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
630	SARKEGAD RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
631	ADANCHULI RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
632	KHARPUNATH RURAL MUNICIPALITY	61	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
633	CHHEDAGAD MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
634	KUSE RURAL MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
635	SHIWALAYA RURAL MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
636	BAREKOT RURAL MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
637	JUNICHANDE RURAL MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
638	NALAGAD MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
639	BHERI MUNICIPALITY	62	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
640	CHAMUNDA BINDRASAINI MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
641	BHAIRABI RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
642	MAHABU RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
643	GURANS RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
644	NAUMULE RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
645	BHAGAWATIMAI RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
646	THANTIKANDH RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
647	DUNGESHWOR RURAL MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
648	AATHABIS MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
649	DULLU MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
650	NARAYAN MUNICIPALITY	63	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
651	GURBHAKOT MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
652	BARAHTAL RURAL MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
653	CHINGAD RURAL MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
654	SIMTA RURAL MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
655	CHAUKUNE RURAL MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
656	BIRENDRANAGAR MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
657	LEKBESHI MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
658	BHERIGANGA MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
659	PANCHPURI MUNICIPALITY	64	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
660	MUSIKOT MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
661	TRIBENI RURAL MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
662	SANI BHERI RURAL MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
663	BANFIKOT RURAL MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
664	AATHBISKOT MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
665	CHAURJAHARI MUNICIPALITY	76	6	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
666	KHAPTAD CHHEDEDAHA RURAL MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
667	GAUMUL RURAL MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
668	HIMALI RURAL MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
669	JAGANNATH RURAL MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
670	SWAMI KARTIK KHAAPAR RURAL MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
671	BADIMALIKA MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
672	TRIBENI MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
673	BUDHIGANGA MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
674	BUDHINANDA MUNICIPALITY	67	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
675	PANCHADEWAL BINAYAK MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
676	DHAKARI RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
677	MELLEKH RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
678	CHAURPATI RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
679	RAMAROSHAN RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
680	TURMAKHAD RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
681	BANNIGADHI JAYAGADH RURAL MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
682	SANPHEBAGAR MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
683	MANGALSEN MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
684	KAMALBAZAR MUNICIPALITY	68	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
685	CHABISPATHIVERA RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
686	JAYAPRITHIVI MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
687	BUNGAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
688	MASTA RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
689	THALARA RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
690	TALKOT RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
691	SURMA RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
692	SAIPAAL RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
693	DURGATHALI RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
694	BITHADCHIR RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
695	KEDARSEU RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
696	KHAPTADCHHANNA RURAL MUNICIPALITY	69	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
697	ADHARSHA RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
698	SHIKHAR MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
699	DIPAYAL SILGADI MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
700	BOGTAN FOODSIL RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
701	K I SINGH RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
702	PURBICHAUKI RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
703	BADIKEDAR RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
704	JORAYAL RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
705	SAYAL RURAL MUNICIPALITY	70	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
706	DHANGADHI SUB-METROPOLITIAN CITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
707	GHODAGHODI MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
708	JOSHIPUR RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
709	KAILARI RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
710	JANAKI RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
711	CHURE RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
712	MOHANYAL RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
713	LAMKICHUHA MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
714	GODAWARI MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
715	GAURIGANGA MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
716	BHAJANI MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
717	BARDAGORIYA RURAL MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
718	TIKAPUR MUNICIPALITY	71	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
719	DUNHU RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
720	LEKAM RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:35	2025-12-13 21:34:35
721	NAUGAD RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
722	SHAILYASHIKHAR MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
723	MAHAKALI MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
724	MALIKAARJUN RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
725	APIHIMAL RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
726	MARMA RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
727	BYAS RURAL MUNICIPALITY	72	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
728	SURNAYA RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
729	PATAN MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
730	PURCHAUDI MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
731	DASHARATHCHANDA MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
732	MELAULI MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
733	DOGADAKEDAR RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
734	PANCHESHWAR RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
735	DILASAINI RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
736	SHIVANATH RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
737	SIGAS RURAL MUNICIPALITY	73	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
738	GANAYAPDHURA RURAL MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
739	AMARGADHI MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
740	PARASHURAM MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
741	AJAYMERU RURAL MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
742	BHAGESHWAR RURAL MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
743	ALITAL RURAL MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
744	NAWADURGA RURAL MUNICIPALITY	74	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
745	BHIMDATTA MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
746	BEDKOT MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
747	BELAURI MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
748	MAHAKALI MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
749	KRISHNAPUR MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
750	PUNARBAS MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
751	LALJHADI RURAL MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
752	BELDANDI RURAL MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
753	SHUKLAPHANTA MUNICIPALITY	75	7	f	\N	\N	\N	\N	\N	\N	2025-12-13 21:34:36	2025-12-13 21:34:36
\.


--
-- Name: audits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audits_id_seq', 6, true);


--
-- Name: claim_notes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.claim_notes_id_seq', 1, false);


--
-- Name: claim_registers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.claim_registers_id_seq', 1, false);


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 3, true);


--
-- Name: company_policies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.company_policies_id_seq', 1, true);


--
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.countries_id_seq', 1, false);


--
-- Name: districts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.districts_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: fiscal_years_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fiscal_years_id_seq', 1, false);


--
-- Name: form_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.form_permission_id_seq', 19, true);


--
-- Name: group_headings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.group_headings_id_seq', 1, true);


--
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.groups_id_seq', 2, true);


--
-- Name: insurance_claim_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.insurance_claim_logs_id_seq', 1, false);


--
-- Name: insurance_claims_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.insurance_claims_id_seq', 1, false);


--
-- Name: insurance_headings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.insurance_headings_id_seq', 5, true);


--
-- Name: insurance_sub_headings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.insurance_sub_headings_id_seq', 7, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: member_attachments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.member_attachments_id_seq', 1, false);


--
-- Name: member_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.member_details_id_seq', 1, false);


--
-- Name: member_policies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.member_policies_id_seq', 1, false);


--
-- Name: member_relatives_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.member_relatives_id_seq', 1, false);


--
-- Name: members_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.members_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 56, true);


--
-- Name: module_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.module_permission_id_seq', 32, true);


--
-- Name: modules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.modules_id_seq', 30, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 1, false);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: premium_calculations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.premium_calculations_id_seq', 1, true);


--
-- Name: scrunities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.scrunities_id_seq', 1, false);


--
-- Name: scrunity_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.scrunity_details_id_seq', 1, false);


--
-- Name: settlements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settlements_id_seq', 1, false);


--
-- Name: states_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.states_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: usertype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usertype_id_seq', 3, true);


--
-- Name: vdcmcpts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vdcmcpts_id_seq', 1, false);


--
-- Name: audits audits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audits
    ADD CONSTRAINT audits_pkey PRIMARY KEY (id);


--
-- Name: claim_notes claim_notes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_notes
    ADD CONSTRAINT claim_notes_pkey PRIMARY KEY (id);


--
-- Name: claim_registers claim_registers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_registers
    ADD CONSTRAINT claim_registers_pkey PRIMARY KEY (id);


--
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: company_policies company_policies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_policies
    ADD CONSTRAINT company_policies_pkey PRIMARY KEY (id);


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- Name: districts districts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT districts_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: fiscal_years fiscal_years_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fiscal_years
    ADD CONSTRAINT fiscal_years_pkey PRIMARY KEY (id);


--
-- Name: form_permission form_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_permission
    ADD CONSTRAINT form_permission_pkey PRIMARY KEY (id);


--
-- Name: group_headings group_headings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_headings
    ADD CONSTRAINT group_headings_pkey PRIMARY KEY (id);


--
-- Name: groups groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- Name: insurance_claim_logs insurance_claim_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claim_logs
    ADD CONSTRAINT insurance_claim_logs_pkey PRIMARY KEY (id);


--
-- Name: insurance_claims insurance_claims_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_pkey PRIMARY KEY (id);


--
-- Name: insurance_headings insurance_headings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_headings
    ADD CONSTRAINT insurance_headings_pkey PRIMARY KEY (id);


--
-- Name: insurance_sub_headings insurance_sub_headings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_sub_headings
    ADD CONSTRAINT insurance_sub_headings_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: member_attachments member_attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_attachments
    ADD CONSTRAINT member_attachments_pkey PRIMARY KEY (id);


--
-- Name: member_details member_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_details
    ADD CONSTRAINT member_details_pkey PRIMARY KEY (id);


--
-- Name: member_policies member_policies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_policies
    ADD CONSTRAINT member_policies_pkey PRIMARY KEY (id);


--
-- Name: member_relatives member_relatives_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_relatives
    ADD CONSTRAINT member_relatives_pkey PRIMARY KEY (id);


--
-- Name: members members_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: module_permission module_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.module_permission
    ADD CONSTRAINT module_permission_pkey PRIMARY KEY (id);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: premium_calculations premium_calculations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.premium_calculations
    ADD CONSTRAINT premium_calculations_pkey PRIMARY KEY (id);


--
-- Name: scrunities scrunities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities
    ADD CONSTRAINT scrunities_pkey PRIMARY KEY (id);


--
-- Name: scrunity_details scrunity_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunity_details
    ADD CONSTRAINT scrunity_details_pkey PRIMARY KEY (id);


--
-- Name: settlements settlements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settlements
    ADD CONSTRAINT settlements_pkey PRIMARY KEY (id);


--
-- Name: states states_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: usertype usertype_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usertype
    ADD CONSTRAINT usertype_pkey PRIMARY KEY (id);


--
-- Name: vdcmcpts vdcmcpts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vdcmcpts
    ADD CONSTRAINT vdcmcpts_pkey PRIMARY KEY (id);


--
-- Name: audits_auditable_type_auditable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX audits_auditable_type_auditable_id_index ON public.audits USING btree (auditable_type, auditable_id);


--
-- Name: audits_user_id_user_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX audits_user_id_user_type_index ON public.audits USING btree (user_id, user_type);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: users_usertype_fname_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX users_usertype_fname_index ON public.users USING btree (usertype, fname);


--
-- Name: claim_notes claim_notes_claim_no_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_notes
    ADD CONSTRAINT claim_notes_claim_no_id_foreign FOREIGN KEY (claim_no_id) REFERENCES public.claim_registers(id);


--
-- Name: claim_notes claim_notes_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claim_notes
    ADD CONSTRAINT claim_notes_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id);


--
-- Name: clients clients_city_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_city_id_foreign FOREIGN KEY (city_id) REFERENCES public.vdcmcpts(id);


--
-- Name: clients clients_district_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_district_id_foreign FOREIGN KEY (district_id) REFERENCES public.districts(id);


--
-- Name: clients clients_province_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_province_id_foreign FOREIGN KEY (province_id) REFERENCES public.states(id);


--
-- Name: company_policies company_policies_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_policies
    ADD CONSTRAINT company_policies_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id);


--
-- Name: districts districts_state_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT districts_state_id_foreign FOREIGN KEY (state_id) REFERENCES public.states(id) ON DELETE SET NULL;


--
-- Name: group_headings group_headings_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_headings
    ADD CONSTRAINT group_headings_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.groups(id);


--
-- Name: group_headings group_headings_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_headings
    ADD CONSTRAINT group_headings_heading_id_foreign FOREIGN KEY (heading_id) REFERENCES public.insurance_headings(id);


--
-- Name: groups groups_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id);


--
-- Name: groups groups_policy_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_policy_id_foreign FOREIGN KEY (policy_id) REFERENCES public.company_policies(id);


--
-- Name: insurance_claim_logs insurance_claim_logs_audit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claim_logs
    ADD CONSTRAINT insurance_claim_logs_audit_id_foreign FOREIGN KEY (audit_id) REFERENCES public.audits(id);


--
-- Name: insurance_claim_logs insurance_claim_logs_insurance_claim_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claim_logs
    ADD CONSTRAINT insurance_claim_logs_insurance_claim_id_foreign FOREIGN KEY (insurance_claim_id) REFERENCES public.insurance_claims(id);


--
-- Name: insurance_claims insurance_claims_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.groups(id);


--
-- Name: insurance_claims insurance_claims_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_heading_id_foreign FOREIGN KEY (heading_id) REFERENCES public.insurance_headings(id);


--
-- Name: insurance_claims insurance_claims_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: insurance_claims insurance_claims_register_no_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_register_no_foreign FOREIGN KEY (register_no) REFERENCES public.claim_registers(id);


--
-- Name: insurance_claims insurance_claims_relative_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_relative_id_foreign FOREIGN KEY (relative_id) REFERENCES public.member_relatives(id);


--
-- Name: insurance_claims insurance_claims_scrutiny_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_scrutiny_id_foreign FOREIGN KEY (scrutiny_id) REFERENCES public.scrunities(id);


--
-- Name: insurance_claims insurance_claims_sub_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_claims
    ADD CONSTRAINT insurance_claims_sub_heading_id_foreign FOREIGN KEY (sub_heading_id) REFERENCES public.insurance_sub_headings(id);


--
-- Name: insurance_sub_headings insurance_sub_headings_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance_sub_headings
    ADD CONSTRAINT insurance_sub_headings_heading_id_foreign FOREIGN KEY (heading_id) REFERENCES public.insurance_headings(id);


--
-- Name: member_attachments member_attachments_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_attachments
    ADD CONSTRAINT member_attachments_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: member_details member_details_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_details
    ADD CONSTRAINT member_details_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id) ON DELETE CASCADE;


--
-- Name: member_policies member_policies_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_policies
    ADD CONSTRAINT member_policies_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.groups(id);


--
-- Name: member_policies member_policies_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_policies
    ADD CONSTRAINT member_policies_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: member_policies member_policies_policy_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_policies
    ADD CONSTRAINT member_policies_policy_id_foreign FOREIGN KEY (policy_id) REFERENCES public.company_policies(id);


--
-- Name: member_relatives member_relatives_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member_relatives
    ADD CONSTRAINT member_relatives_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: members members_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id);


--
-- Name: members members_perm_city_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_perm_city_foreign FOREIGN KEY (perm_city) REFERENCES public.vdcmcpts(id);


--
-- Name: members members_perm_district_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_perm_district_foreign FOREIGN KEY (perm_district) REFERENCES public.districts(id);


--
-- Name: members members_perm_province_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_perm_province_foreign FOREIGN KEY (perm_province) REFERENCES public.states(id);


--
-- Name: members members_present_district_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_present_district_foreign FOREIGN KEY (present_district) REFERENCES public.districts(id);


--
-- Name: members members_present_province_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_present_province_foreign FOREIGN KEY (present_province) REFERENCES public.states(id);


--
-- Name: members members_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.members
    ADD CONSTRAINT members_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: notifications notifications_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: scrunities scrunities_claim_no_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities
    ADD CONSTRAINT scrunities_claim_no_id_foreign FOREIGN KEY (claim_no_id) REFERENCES public.claim_registers(id);


--
-- Name: scrunities scrunities_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities
    ADD CONSTRAINT scrunities_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: scrunities scrunities_member_policy_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities
    ADD CONSTRAINT scrunities_member_policy_id_foreign FOREIGN KEY (member_policy_id) REFERENCES public.member_policies(id);


--
-- Name: scrunities scrunities_relative_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunities
    ADD CONSTRAINT scrunities_relative_id_foreign FOREIGN KEY (relative_id) REFERENCES public.member_relatives(id);


--
-- Name: scrunity_details scrunity_details_group_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunity_details
    ADD CONSTRAINT scrunity_details_group_heading_id_foreign FOREIGN KEY (group_heading_id) REFERENCES public.group_headings(id) ON DELETE CASCADE;


--
-- Name: scrunity_details scrunity_details_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunity_details
    ADD CONSTRAINT scrunity_details_heading_id_foreign FOREIGN KEY (heading_id) REFERENCES public.insurance_headings(id) ON DELETE CASCADE;


--
-- Name: scrunity_details scrunity_details_scrunity_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scrunity_details
    ADD CONSTRAINT scrunity_details_scrunity_id_foreign FOREIGN KEY (scrunity_id) REFERENCES public.scrunities(id) ON DELETE CASCADE;


--
-- Name: settlements settlements_group_heading_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settlements
    ADD CONSTRAINT settlements_group_heading_id_foreign FOREIGN KEY (group_heading_id) REFERENCES public.group_headings(id);


--
-- Name: settlements settlements_member_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settlements
    ADD CONSTRAINT settlements_member_id_foreign FOREIGN KEY (member_id) REFERENCES public.members(id);


--
-- Name: states states_country_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.states
    ADD CONSTRAINT states_country_id_foreign FOREIGN KEY (country_id) REFERENCES public.countries(id);


--
-- Name: users users_usertype_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_usertype_foreign FOREIGN KEY (usertype) REFERENCES public.usertype(id);


--
-- Name: vdcmcpts vdcmcpts_district_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vdcmcpts
    ADD CONSTRAINT vdcmcpts_district_id_foreign FOREIGN KEY (district_id) REFERENCES public.districts(id) ON DELETE SET NULL;


--
-- Name: vdcmcpts vdcmcpts_state_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vdcmcpts
    ADD CONSTRAINT vdcmcpts_state_id_foreign FOREIGN KEY (state_id) REFERENCES public.states(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

\unrestrict etFDGvBksYwOgGX6dINgypKuGKsHhlTdu1LwzFSM4sh9jO2hfLZ7sW1HCkv6QXg

